<?php
#!/usr/bin/php
defined('BASEPATH') or exit('No direct script access allowed');

if (PHP_SAPI !== 'cli') {
    show_404();
    die();
}

set_time_limit(0);
ini_set('memory_limit', '512M');

class Matches extends MY_Controller
{
    private $baseController;
    private $baseModel;
    private $baseMigration;

    /**
     * Template Location
     *
     * @var string
     */
    private $baseLocation;

    const FORMAT_ENTER = "\n";
    const FORMAT_DOUBLE_ENTER = "\n\n";

    private $findAndReplace = array();

    /**
     * Matches constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->config->load('matches', true);
        $this->baseLocation = APPPATH . $this->config->item('templates', 'matches');

        // Init Config
        $this->baseController = $this->config->item('controller', 'matches');
        $this->baseModel = $this->config->item('model', 'matches');
        $this->baseMigration = $this->config->item('migration', 'matches');

        $this->load->helper('file');
    }

    /**
     *
     * return string
     */
    public function index()
    {
        echo 'Hello. Need help to ignite somethin\'?' . self::FORMAT_ENTER;
    }

    /**
     * List the available commands
     *
     * @return void
     */
    public function help(): void
    {
        echo self::FORMAT_ENTER . "Available commands:";

        echo self::FORMAT_DOUBLE_ENTER . "GENERATOR";
        echo self::FORMAT_ENTER . "- create:app {name of app}";
        echo self::FORMAT_ENTER . "- create:controller {name of controller}";
        echo self::FORMAT_ENTER . "- create:migration {name of migration} {name of table - opsional}";
        echo self::FORMAT_ENTER . "- create:model {name of model}";
        echo self::FORMAT_ENTER . "- create:view {name of view}";
        echo self::FORMAT_ENTER;
    }

    /**
     * @param null $app
     */
    public function create_app($app = null)
    {
        if (isset($app)) {
            $this->create_controller($app);
            $this->create_model($app);
            $this->create_view($app);
        } else {
            echo self::FORMAT_ENTER . 'You need to provide a name for the app';
        }
    }

    /**
     * create controller
     * returns boolean true
     *
     * @return bool|void
     */
    public function create_controller()
    {
        try {
            $available = array('extend' => 'extend', 'e' => 'extend');
            $params = func_get_args();
            $arguments = array();

            foreach ($params as $parameter) {
                $argument = explode(':', $parameter);
                if (sizeof($argument) == 1 && !isset($controller)) {
                    $controller = $argument[0];
                } elseif (array_key_exists($argument[0], $available)) {
                    $arguments[$available[$argument[0]]] = $argument[1];
                }
            }

            if (!$controller) {
                throw new Exception('You need to provide a name for the controller.');
            }

            $names = $this->setName($controller, 'controllers');
            $className = $names['class'];
            $fileName = $names['file'];
            $directories = $names['directories'];
            $is_module = $names['is_module'];

            $basePath = $is_module ? FCPATH . "../" : APPPATH;

            if (file_exists($basePath . $fileName . '.php')) {
                throw new Exception($className . ' Controller already exists in the application/controllers' . $directories . ' directory.');
            }

            $extends = array_key_exists('extend', $arguments) ? $arguments['extend'] : $this->baseController;
            $extends = in_array(strtolower($extends), array('my', 'ci', 'mx')) ? strtoupper($extends) : ucfirst($extends);

            $this->findAndReplace['{{CONTROLLER}}'] = $className;
            $this->findAndReplace['{{CONTROLLER_FILE}}'] = $fileName . '.php';
            $this->findAndReplace['{{MODEL}}'] = $className;
            $this->findAndReplace['{{MODEL_ALIAS}}'] = strtolower($className);
            $this->findAndReplace['{{C_EXTENDS}}'] = $extends;

            $template = $this->getTemplate('controller');
            $template = strtr($template, $this->findAndReplace);
            if (strlen($directories) > 0 && !file_exists($basePath . $directories)) {
                mkdir($basePath . $directories, 0777, true);
            }

            if (!write_file($basePath . $fileName . '.php', $template)) {
                throw new Exception('Couldn\'t write Controller.');
            }

            echo self::FORMAT_ENTER . 'Controller ' . $className . ' has been created inside ' . $basePath . $directories . '.';
            echo self::FORMAT_ENTER;
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo self::FORMAT_ENTER;
        }
    }

    /**
     * create model
     * returns boolean true
     *
     * @return bool|void
     */
    public function create_model()
    {
        try {

            $available = array('extend' => 'extend', 'e' => 'extend');
            $params = func_get_args();
            $arguments = array();

            foreach ($params as $parameter) {
                $argument = explode(':', $parameter);
                if (sizeof($argument) == 1 && !isset($model)) {
                    $model = $argument[0];
                } elseif (array_key_exists($argument[0], $available)) {
                    $arguments[$available[$argument[0]]] = $argument[1];
                }
            }

            if (!$model) {
                throw new Exception('You need to provide a name for the model.');
            }

            $names = $this->setName($model, 'models');
            $className = $names['class'];
            $fileName = $names['file'];
            $directories = $names['directories'];
            $is_module = $names['is_module'];

            $basePath = $is_module ? FCPATH . "../" : APPPATH;

            if (file_exists($basePath . $fileName . '.php')) {
                throw new Exception($className . ' Model already exists in the application/models' . $directories . ' directory.');
            }

            $extends = array_key_exists('extend', $arguments) ? $arguments['extend'] : $this->baseModel;
            $extends = in_array(strtolower($extends), array('my', 'ci', 'mx')) ? strtoupper($extends) : ucfirst($extends);

            $this->findAndReplace['{{MODEL}}'] = $className;
            $this->findAndReplace['{{MODEL_FILE}}'] = $fileName . '.php';
            $this->findAndReplace['{{MO_EXTENDS}}'] = $extends;

            $template = $this->getTemplate('model');
            $template = strtr($template, $this->findAndReplace);
            if (strlen($directories) > 0 && !file_exists($basePath . $directories)) {
                mkdir($basePath . $directories, 0777, true);
            }

            if (!write_file($basePath . $fileName . '.php', $template)) {
                throw new Exception('Couldn\'t write Model.');
            }

            echo self::FORMAT_ENTER . 'Model ' . $className . ' has been created inside ' . $basePath . $directories . '.';
            echo self::FORMAT_ENTER;
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo self::FORMAT_ENTER;
        }
    }

    /**
     * create view
     *
     * @param null $view
     *
     * @return bool|string|void
     */
    public function create_view($view = null)
    {

        try {
            $available = array();
            $params = func_get_args();
            $arguments = array();

            foreach ($params as $parameter) {
                $argument = explode(':', $parameter);
                if (sizeof($argument) == 1 && !isset($view)) {
                    $view = $argument[0];
                } elseif (array_key_exists($argument[0], $available)) {
                    $arguments[$available[$argument[0]]] = $argument[1];
                }
            }

            if (!$view) {
                throw new Exception('You need to provide a name for the view file.');
            }

            $names = $this->setName($view, 'views');
            $fileName = strtolower($names['file']);
            $directories = $names['directories'];
            $is_module = $names['is_module'];

            $basePath = $is_module ? FCPATH . "../" : APPPATH;
            if (file_exists($basePath . $fileName . '.php')) {
                throw new Exception($fileName . ' View already exists in the application/views/' . $directories . ' directory.');
            }

            $this->findAndReplace['{{VIEW}}'] = $fileName . '.php';
            $template = $this->getTemplate('view');
            $template = strtr($template, $this->findAndReplace);

            if (strlen($directories) > 0 && !file_exists($basePath . $directories)) {
                mkdir($basePath . $directories, 0777, true);
            }

            if (!write_file($basePath . $fileName . '.php', $template)) {
                throw new Exception('Couldn\'t write View.');
            }

            echo self::FORMAT_ENTER . 'View ' . $fileName . ' has been created inside ' . $basePath . $directories . '.';
            echo self::FORMAT_ENTER;
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo self::FORMAT_ENTER;
        }
    }


    /**
     * do_migration
     *
     * @param  mixed $version
     * @return void
     */
    public function do_migration(?string $version = null): void
    {
        try {

            $this->load->library('migration');

            $check = $version ? $this->migration->version($version) : $this->migration->latest();
            if (!$check) {
                throw new Exception($this->migration->error_string());
            }

            echo 'The migration has concluded successfully.';
            echo self::FORMAT_ENTER;
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo self::FORMAT_ENTER;
        }
    }

    /**
     * @param null $version
     *
     * @return bool|void
     */
    public function undo_migration($version = null)
    {
        $this->load->library('migration');
        $migrations = $this->migration->find_migrations();
        $migration_keys = array();
        foreach ($migrations as $key => $migration) {
            $migration_keys[] = $key;
        }

        if (isset($version) && array_key_exists($version, $migrations) && $this->migration->version($version)) {
            echo self::FORMAT_ENTER . 'The migration was reset to the version: ' . $version;
            return true;
        } elseif (isset($version) && !array_key_exists($version, $migrations)) {
            echo self::FORMAT_ENTER . 'The migration with version number ' . $version . ' doesn\'t exist.';
        } else {
            $penultimate = (sizeof($migration_keys) == 1) ? 0 : $migration_keys[sizeof($migration_keys) - 2];
            if ($this->migration->version($penultimate)) {
                echo self::FORMAT_ENTER . 'The migration has been rolled back successfully.';
                return true;
            } else {
                echo self::FORMAT_ENTER . 'Couldn\'t roll back the migration.';
                return false;
            }
        }

        echo self::FORMAT_ENTER;
    }

    /**
     * @return bool
     */
    public function reset_migration()
    {
        $this->load->library('migration');
        if ($this->migration->current() !== false) {
            echo self::FORMAT_ENTER . 'The migration was reset to the version set in the config file.';
            return true;
        } else {
            echo self::FORMAT_ENTER . 'Couldn\'t reset migration.';
            show_error($this->migration->error_string());
            return false;
        }
    }

    /**
     * @return bool
     */
    public function create_migration()
    {
        $available = array('extend' => 'extend', 'e' => 'extend', 'table' => 'table', 't' => 'table');
        $params = func_get_args();

        try {
            // Mapping Params
            $arguments = array();
            foreach ($params as $parameter) {
                $argument = explode(':', $parameter);
                if (sizeof($argument) == 1 && !isset($action)) {
                    $action = $argument[0];
                } elseif (array_key_exists($argument[0], $available)) {
                    $arguments[$available[$argument[0]]] = $argument[1];
                }
            }

            if (!$action) {
                throw new Exception('You need to provide a name for the migration.');
            }

            // Init Data
            $this->config->load('migration', true);
            $migrationPath = $this->config->item('migration_path', 'migration');
            $migrationType = $this->config->item('migration_type', 'migration') ?? 'sequential';
            $className = 'Migration_' . ucfirst($action);

            if ($migrationType == 'timestamp') {
                $fileName = date('YmdHis') . '_' . strtolower($action);
            } else {
                $latest_migration = 0;
                foreach (glob($migrationPath . '*.php') as $migration) {
                    $pattern = '/[0-9]{3}/';
                    if (preg_match($pattern, $migration, $matches)) {
                        $migration_version = intval($matches[0]);
                        $latest_migration = ($migration_version > $latest_migration) ? $migration_version : $latest_migration;
                    }
                }
                $latest_migration = (string)++$latest_migration;
                $fileName = str_pad($latest_migration, 3, '0', STR_PAD_LEFT) . '_' . strtolower($action);
            }

            if (file_exists($migrationPath . $fileName) or (class_exists($className))) {
                throw new Exception($className . ' Migration already exists.');
            }

            $extends = array_key_exists('extend', $arguments) ? $arguments['extend'] : $this->baseMigration;
            $extends = in_array(strtolower($extends), array('my', 'ci', 'mx')) ? strtoupper($extends) : ucfirst($extends);

            $table = 'SET_YOUR_TABLE_HERE';
            if (array_key_exists('table', $arguments)) {
                $table = $arguments['table'];
            }

            // Setup
            $this->findAndReplace['{{MIGRATION}}'] = $className;
            $this->findAndReplace['{{MIGRATION_FILE}}'] = $fileName;
            $this->findAndReplace['{{MIGRATION_PATH}}'] = $migrationPath;
            $this->findAndReplace['{{MI_EXTENDS}}'] = $extends;
            $this->findAndReplace['{{TABLE}}'] = $table;

            // Replace
            $template = $this->getTemplate('migration');
            $template = strtr($template, $this->findAndReplace);
            if (!write_file($migrationPath . $fileName . '.php', $template)) {
                throw new Exception('Couldn\'t write Migration.');
            }

            echo self::FORMAT_ENTER . 'Migration ' . $className . ' has been created.';
            echo self::FORMAT_ENTER;
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo self::FORMAT_ENTER;
        }
    }

    /**
     * setName
     *
     * @param  string $str
     * @param  string $type
     * @return array
     */
    private function setName(string $str, string $type): array
    {
        $str = strtolower($str);

        if (strpos($str, '.')) {
            $structure = explode('.', $str);
            array_unshift($structure, 'modules');
            $className = array_pop($structure);

            array_push($structure, $type);
            $isModule = TRUE;
        } else {
            $structure = array();
            array_push($structure, $type);
            $className = $str;
            $isModule = FALSE;
        }

        $className = ucfirst($className);
        $directories = implode('/', $structure);
        $file = $directories . '/' . $className;

        return array(
            'file' => $file,
            'class' => $className,
            'directories' => $directories,
            'is_module' => $isModule
        );
    }

    /**
     * @param $str
     *
     * @return string
     */
    private function fileName($str)
    {
        return ucfirst($str);
    }

    /**
     * @param $type
     *
     * @return bool|false|string
     */
    private function getTemplate($type)
    {
        try {
            $templateLocation = $this->baseLocation . $type . '_template.txt';
            if (!file_exists($templateLocation)) {
                throw new Exception('Couldn\'t find ' . $type . ' template.');
            }

            return file_get_contents($templateLocation);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param       $method
     * @param array $params
     *
     * @return mixed|void
     */
    public function _remap($method, $params = array())
    {
        if (strpos($method, ':')) {
            $method = str_replace(':', '_', $method);
        }

        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
    }
}
