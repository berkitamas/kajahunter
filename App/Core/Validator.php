<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 22:44
 */

namespace App\Core;


use App\DAO\CommonDAO;
use App\Model\WhereClause;

class Validator {
    private $passed = false,
        $errors = array(),
        $source = array();

    public function __construct($source) {
        $this->source = $source;
    }

    public function check($items = array()) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
                if(isset($this->source[$item])) {
                    $value = $this->source[$item];
                }
                if(isset($value) && is_string($value)) {
                    $value = trim($value);
                }
                //e.g. "required", would be "required"=>true,
                if (self::isNumeric($rule) && !empty($rule_value)) {
                    $rule = $rule_value;
                    $rule_value = true;
                }

                //if we need two entry with smae checking we can use # to escape it
                //e.g. "unique#restaurant" => array(...), "unique#consumer=> array(...),
                if (strpos($rule, "#") !== false) {
                    $rule = explode("#", $rule)[0];
                }

                if($rule === 'required' && empty($value)) {
                    $this->addError("A(z) {$rules['field_name']} megadása kötelező!");
                } elseif($rule === 'checked' && !self::isCheckboxChecked($value)) {
                    $this->addError("A(z) {$rules['field_name']} gombot be kell jelölni.");
                } elseif (!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if(!self::isLengthNotLess($rule_value, $value)) {
                                $this->addError("A(z) {$rules['field_name']}-nak/nek legalább {$rule_value} karakterből kell állnia.");
                            }
                            break;
                        case 'max':
                            if(!self::isLengthNotGreater($rule_value, $value)) {
                                $this->addError("A(z) {$rules['field_name']}-nak/nek legfeljebb {$rule_value} karakterből kell állnia.");
                            }
                            break;
                        case 'not_matches':
                            if(self::isMatch($value, $this->source[$rule_value])) {
                                $this->addError("A(z) {$items[$rule_value]['field_name']}-nak/nek nem szabad egyeznie {$rules['field_name']}-val/vel.");
                            }
                            break;
                        case 'matches':
                            if(!self::isMatch($value, $this->source[$rule_value])) {
                                $this->addError("A(z) {$items[$rule_value]['field_name']}-nak/nek egyeznie kell {$rules['field_name']}-val/vel.");
                            }
                            break;
                        case 'unique':
                            if(!self::isUnique($rule_value, $value)) {
                                $this->addError("A(z) {$rules['field_name']} már létezik.");
                            }
                            break;
                        case 'extension':
                            if (!self::hasExtension($value, $rule_value)) {
                                $this->addError("A(z) {$rules['field_name']}-nak/nek {$rule_value} kiterjesztésűnek kell lennie.");
                            }
                            break;
                        case 'has_digits':
                            if(!self::hasDigits($value)) {
                                $this->addError("A(z) {$rules['field_name']}-nak/nek tartalmaznia kell számot.");
                            }
                            break;
                        case 'only_digits':
                            if(!self::isNumeric($value)) {
                                $this->addError("A(z) {$rules['field_name']}-nak/nek csak számokból kell állnia.");
                            }
                            break;
                        case 'not_only_digits':
                            if (self::isNumeric($value)) {
                                $this->addError("A(z) {$rules['field_name']}-nak/nek nem szabad csak számokból állnia.");
                            }
                            break;
                        case 'only_letters':
                            if (!self::isOnlyLetters($value)) {
                                $this->addError("A(z) {$rules['field_name']}-nak/nek csak betűkből szabad állnia.");
                            }
                            break;
                        case 'email':
                            if(!self::isEmail($value)) {
                                $this->addError("A(z) {$rules['field_name']} hibás formátumú.");
                            }
                            break;
                        case 'url_reachable':
                            if(self::isUrlReachable($value)) {
                                $this->addError("A(z) {$rules['field_name']} nem található.");
                            }
                            break;
                        case 'maxwidth':
                            if(self::isImageWidthNotGreaterThan($rule_value, $value)) {
                                $this->addError("A(z) {$rules['field_name']} szélességének nem szabad nagyobbnak lenni, mint {$rule_value}px.");
                            }
                            break;
                        case 'maxheight':
                            if(self::isImageHeightNotGreaterThan($rule_value, $value)) {
                                $this->addError("A(z) {$rules['field_name']} magasságának nem szabad nagyobbnak lenni, mint {$rule_value}px.");
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        if(empty($this->errors)) {
            $this->passed = true;
        }
    }

    public static function isLengthNotLess(int $minLength, string $value): bool {
        return (strlen($value) >= $minLength);
    }

    public static function isLengthNotGreater(int $maxLength, string $value): bool {
        return (strlen($value) <= $maxLength);
    }

    public static function isMatch($value1, $value2): bool {
        return ($value1 == $value2);
    }

    public static function isCheckboxChecked($value): bool {
        return ($value == "on");
    }

    public static function isUnique(array $df, $value): bool {
        return !$df[0]->has(new WhereClause($df[1], "==", $value));
    }

    public static function hasExtension($file, $extension): bool {
        $filepart = pathinfo($file["name"]);
        return ($filepart['extension'] == $extension);
    }

    public static function isNumeric($value): bool {
        return is_numeric($value);
    }

    public static function isOnlyLetters($value): bool {
        return !preg_match('/[^A-Za-z]/', $value);
    }

    public static function hasDigits($value) {
        return preg_match('/[0-9]/', $value) != false;
    }

    public static function isEmail($value): bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function isUrlReachable($url): bool {
        $headers = get_headers($url, 1);
        return strpos($headers[0], "200") !== false;
    }

    public static function isImageWidthNotGreaterThan($maxwidth, $image): bool {
        return (getimagesize($image)[0] <= $maxwidth);
    }

    public static function isImageHeightNotGreaterThan($maxheight, $image): bool {
        return (getimagesize($image)[1] <= $maxheight);
    }

    private function addError($error) {
        $this->errors[] = $error;
    }

    public function errors() {
        return $this->errors;
    }

    public function passed() {
        return $this->passed;
    }
}