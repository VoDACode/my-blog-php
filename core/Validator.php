<?

namespace core;

class Validator{

    private $rules = [];

    private $errors = [];

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    /*
    data => [
        'login' => [
            'required',
            'min:5',
            'max:20'
        ],
    ]
    */

    public function validate($data)
    {
        foreach($this->rules as $field => $rules){
            if(!isset($data[$field])){
                if(in_array('required', $rules)){
                    $this->errors[$field] = 'Field "'.$field.'" is required';
                }
                continue;
            }
            foreach($rules as $rule){
                $rule = explode(':', $rule);
                $method = 'validate'.ucfirst($rule[0]);
                if(method_exists($this, $method)){
                    $this->$method($field, $data[$field], $rule);
                }
            }
        }
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function validateRequired($field, $value, $rule)
    {
        if($value == ''){
            $this->errors[$field] = 'Field "'.$field.'" is required';
        }
    }

    private function validateMin($field, $value, $rule)
    {
        if(strlen($value) < $rule[1]){
            $this->errors[$field] = 'Field "'.$field.'" must be at least '.$rule[1].' characters';
        }
    }

    private function validateMax($field, $value, $rule)
    {
        if(strlen($value) > $rule[1]){
            $this->errors[$field] = 'Field "'.$field.'" must be less than '.$rule[1].' characters';
        }
    }

    private function validateEmail($field, $value, $rule)
    {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            $this->errors[$field] = 'Field "'.$field.'" must be a valid email';
        }
    }
}