<?php

    namespace KarimQaderi\Zoroaster\Console;

    use Illuminate\Console\GeneratorCommand;

    class FieldCommand extends GeneratorCommand
    {
        /**
         * The console command name.
         *
         * @var string
         */
        protected $name = 'Zoroaster:field';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Create a new field class';

        /**
         * The type of class being generated.
         *
         * @var string
         */
        protected $type = 'Field';


        /**
         * Get the stub file for the generator.
         *
         * @return string
         */
        protected function getStub()
        {
            $ClassName = $this->input->getArgument('name');
            \Zoroaster::makeDirectory(resource_path('views/fields/' . $ClassName));

            foreach(['Detail' , 'Form' , 'Index'] as $view)
                copy(__DIR__ . '/stubs/empty.stub' , resource_path('views/fields/' . $ClassName . '/' . $view . '.blade.php'));

            return __DIR__ . '/stubs/Field.stub';
        }

        /**
         * Get the default namespace for the class.
         *
         * @param  string $rootNamespace
         * @return string
         */
        protected function getDefaultNamespace($rootNamespace)
        {
            return $rootNamespace . '\Zoroaster\Fields';
        }


    }
