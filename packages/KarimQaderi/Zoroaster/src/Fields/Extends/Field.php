<?php

    namespace KarimQaderi\Zoroaster\Fields\Other;


    use Closure;
    use Illuminate\Support\Str;
    use Illuminate\Support\Traits\Macroable;
    use JsonSerializable;
    use KarimQaderi\Zoroaster\Contracts\Resolvable;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    abstract class Field extends FieldElement implements JsonSerializable , Resolvable
    {
        use Macroable;

        /**
         * The displayable name of the field.
         *
         * @var string
         */
        public $label;

        /**
         * The name / column name of the field.
         *
         * @var string
         */
        public $name;

        /**
         * The field's resolved value.
         *
         * @var mixed
         */
        public $value;

        /**
         * The callback to be used to resolve the field's display value.
         *
         * @var \Closure
         */
        public $displayCallback;

        /**
         * The callback to be used to resolve the field's value.
         *
         * @var \Closure
         */
        public $resolveCallback;

        /**
         * The callback to be used to hydrate the model name.
         *
         * @var callable
         */
        public $fillCallback;

        /**
         * The validation rules for creation and updates.
         *
         * @var array
         */
        public $rules = [];

        /**
         * The validation rules for creation.
         *
         * @var array
         */
        public $creationRules = [];

        /**
         * The validation rules for updates.
         *
         * @var array
         */
        public $updateRules = [];

        /**
         * Indicates if the field should be sortable.
         *
         * @var bool
         */
        public $sortable = false;

        /**
         * The text alignment for the field's text in tables.
         *
         * @var string
         */
        public $textAlign = 'right';

        /**
         * The custom components registered for fields.
         *
         * @var array
         */
        public static $customComponents = [];

        /**
         * Create a new field.
         *
         * @param  string $label
         * @param  string|null $name
         * @param  mixed|null $resolveCallback
         * @return void
         */
        public function __construct($label , $name = null , $resolveCallback = null)
        {
            $this->label = $label;
            $this->resolveCallback = $resolveCallback;
            $this->name = $name ?? str_replace(' ' , '_' , Str::lower($label));
        }

        /**
         * Set the help text for the field.
         *
         * @param  string $helpText
         * @return $this
         */
        public function help($helpText)
        {
            return $this->withMeta(['helpText' => $helpText]);
        }

        /**
         * Resolve the field's value for display.
         *
         * @param  mixed $resource
         * @param  string|null $name
         * @return void
         */
        public function resolveForDisplay($resource , $name = null)
        {
            $name = $name ?? $this->name;

            if($name === 'ComputedField'){
                return;
            }

            if(!$this->displayCallback){
                $this->resolve($resource , $name);
            }

            if(is_callable($this->displayCallback) &&
                data_get($resource , $name , '___missing') !== '___missing'){
                $this->value = call_user_func(
                    $this->displayCallback , data_get($resource , $name)
                );
            }
        }

        /**
         * Resolve the field's value.
         *
         * @param  mixed $resource
         * @param  string|null $name
         * @return void
         */
        public function resolve($resource , $name = null)
        {
            $name = $name ?? $this->name;

            if($name instanceof Closure ||
                (is_callable($name) && is_object($name))){
                return $this->resolveComputedname($name);
            }

            if(!$this->resolveCallback){
                $this->value = $this->resolvename($resource , $name);
            } elseif(is_callable($this->resolveCallback) &&
                data_get($resource , $name , '___missing') !== '___missing'){
                $this->value = call_user_func(
                    $this->resolveCallback , data_get($resource , $name)
                );
            }
        }

        /**
         * Resolve the given name from the given resource.
         *
         * @param  mixed $resource
         * @param  string $name
         * @return mixed
         */
        protected function resolvename($resource , $name)
        {
            if(Str::contains($name , '->')){
                return object_get($resource , str_replace('->' , '.' , $name));
            }

            return data_get($resource , $name);
        }

        /**
         * Resolve a computed name.
         *
         * @param  callable $name
         * @return void
         */
        protected function resolveComputedname($name)
        {
            $this->value = $name();

            $this->name = 'ComputedField';
        }

        /**
         * Define the callback that should be used to resolve the field's value.
         *
         * @param  callable $displayCallback
         * @return $this
         */
        public function displayUsing(callable $displayCallback)
        {
            $this->displayCallback = $displayCallback;

            return $this;
        }

        /**
         * Define the callback that should be used to resolve the field's value.
         *
         * @param  callable $resolveCallback
         * @return $this
         */
        public function resolveUsing(callable $resolveCallback)
        {
            $this->resolveCallback = $resolveCallback;

            return $this;
        }

        /**
         * Hydrate the given name on the model based on the incoming request.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @param  object $model
         * @return void
         */
        public function fill(NovaRequest $request , $model)
        {
            $this->fillInto($request , $model , $this->name);
        }

        /**
         * Hydrate the given name on the model based on the incoming request.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @param  object $model
         * @return void
         */
        public function fillForAction(NovaRequest $request , $model)
        {
            return $this->fill($request , $model);
        }

        /**
         * Hydrate the given name on the model based on the incoming request.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @param  object $model
         * @param  string $name
         * @param  string|null $requestname
         * @return void
         */
        public function fillInto(NovaRequest $request , $model , $name , $requestname = null)
        {
            $this->fillname($request , $requestname ?? $this->name , $model , $name);
        }

        /**
         * Hydrate the given name on the model based on the incoming request.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @param  string $requestname
         * @param  object $model
         * @param  string $name
         * @return void
         */
        protected function
        fillname(NovaRequest $request , $requestname , $model , $name)
        {
            if(isset($this->fillCallback)){
                return call_user_func(
                    $this->fillCallback , $request , $model , $name , $requestname
                );
            }

            $this->fillnameFromRequest(
                $request , $requestname , $model , $name
            );
        }

        /**
         * Hydrate the given name on the model based on the incoming request.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @param  string $requestname
         * @param  object $model
         * @param  string $name
         * @return void
         */
        protected function fillnameFromRequest(NovaRequest $request , $requestname , $model , $name)
        {
            if($request->exists($requestname)){
                $model->{$name} = $request[$requestname];
            }
        }

        /**
         * Specify a callback that should be used to hydrate the model name for the field.
         *
         * @param  callable $fillCallback
         * @return $this
         */
        public function fillUsing($fillCallback)
        {
            $this->fillCallback = $fillCallback;

            return $this;
        }

        /**
         * Set the validation rules for the field.
         *
         * @param  callable|array|string $rules
         * @return $this
         */
        public function rules($rules)
        {
            $this->rules = is_string($rules) ? func_get_args() : $rules;

            return $this;
        }

        /**
         * Get the validation rules for this field.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @return array
         */
        public function getRules(NovaRequest $request)
        {
            return [$this->name => is_callable($this->rules)
                ? call_user_func($this->rules , $request)
                : $this->rules ,];
        }

        /**
         * Get the creation rules for this field.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @return array|string
         */
        public function getCreationRules(NovaRequest $request)
        {
            $rules = [$this->name => is_callable($this->creationRules)
                ? call_user_func($this->creationRules , $request)
                : $this->creationRules ,];

            return array_merge_recursive(
                $this->getRules($request) , $rules
            );
        }

        /**
         * Set the creation validation rules for the field.
         *
         * @param  callable|array|string $rules
         * @return $this
         */
        public function creationRules($rules)
        {
            $this->creationRules = is_string($rules) ? func_get_args() : $rules;

            return $this;
        }

        /**
         * Get the update rules for this field.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @return array
         */
        public function getUpdateRules(NovaRequest $request)
        {
            $rules = [$this->name => is_callable($this->updateRules)
                ? call_user_func($this->updateRules , $request)
                : $this->updateRules ,];

            return array_merge_recursive(
                $this->getRules($request) , $rules
            );
        }

        /**
         * Set the creation validation rules for the field.
         *
         * @param  callable|array|string $rules
         * @return $this
         */
        public function updateRules($rules)
        {
            $this->updateRules = is_string($rules) ? func_get_args() : $rules;

            return $this;
        }

        /**
         * Get the validation name for the field.
         *
         * @param  \Laravel\Nova\Http\Requests\NovaRequest $request
         * @return string
         */
        public function getValidationname(NovaRequest $request)
        {
            return $this->validationname ?? Str::singular($this->name);
        }

        /**
         * Specify that this field should be sortable.
         *
         * @param  bool $value
         * @return $this
         */
        public function sortable($value = true)
        {
            if(!$this->computed()){
                $this->sortable = $value;
            }

            return $this;
        }

        /**
         * Determine if the field is computed.
         *
         * @return bool
         */
        public function computed()
        {
            return is_callable($this->name) ||
                $this->name == 'ComputedField';
        }

        /**
         * Get the component label for the field.
         *
         * @return string
         */
        public function component()
        {
            if(isset(static::$customComponents[get_class($this)])){
                return static::$customComponents[get_class($this)];
            }

            return $this->component;
        }

        /**
         * Set the component that should be used by the field.
         *
         * @param  string $component
         * @return void
         */
        public static function useComponent($component)
        {
            static::$customComponents[get_called_class()] = $component;
        }

        /**
         * Prepare the field for JSON serialization.
         *
         * @return array
         */
        public function jsonSerialize()
        {
            return array_merge([
                'component' => $this->component() ,
                'prefixComponent' => true ,
                'indexName' => $this->label ,
                'label' => $this->label ,
                'name' => $this->name ,
                'value' => $this->value ,
                'panel' => $this->panel ,
                'sortable' => $this->sortable ,
                'textAlign' => $this->textAlign ,
            ] , $this->meta());
        }


        public function beforeResourceStore(RequestField $requestField)
        {
            return null;
        }

        public function ResourceStore(RequestField $requestField)
        {
            return null;

        }

        public function ResourceUpdate(RequestField $requestField)
        {
            return null;

        }

        public function viewForm($data , $field , $newResource = null)
        {
            return view('Zoroaster::fields.Form.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                ]);
        }

        public function viewDetail($data , $field , $newResource = null)
        {
            return view('Zoroaster::fields.Detail.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                ]);
        }

        public function viewIndex($data , $field , $newResource = null)
        {
            return view('Zoroaster::fields.Index.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                ]);
        }
    }
