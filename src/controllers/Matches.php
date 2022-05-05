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
            if (file_exists('application/controllers/' . $this->fileName($app) . '.php') or (class_exists('' . $app . 'Controller')) or (class_exists('' . $app . 'Model'))) {
                echo $app . ' Controller or Model already exists in the application/controllers directory.';
            } else {
                $this->create_controller($app);
                $this->create_model($app);
                $this->create_view($app);
            }
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
        if (isset($controller)) {
            $names = $this->setName($controller);
            $className = $names['class'];
            $fileName = $names['file'];
            $directories = $names['directories'];
            if (file_exists(APPPATH . 'controllers/' . $fileName . '.php')) {
                echo self::FORMAT_ENTER . $className . ' Controller already exists in the application/controllers' . $directories . ' directory.';
            } else {
                $f = $this->getTemplate('controller');
                if ($f === false) {
                    return false;
                }
                $this->findAndReplace['{{CONTROLLER}}'] = $className;
                $this->findAndReplace['{{CONTROLLER_FILE}}'] = $fileName . '.php';
                $this->findAndReplace['{{MV}}'] = strtolower($className);
                $extends = array_key_exists('extend', $arguments) ? $arguments['extend'] : $this->baseController;
                $extends = in_array(strtolower($extends), array('my', 'ci')) ? strtoupper($extends) : ucfirst($extends);
                $this->findAndReplace['{{C_EXTENDS}}'] = $extends;
                $f = strtr($f, $this->findAndReplace);
                if (strlen($directories) > 0 && !file_exists(APPPATH . 'controllers/' . $directories)) {
                    mkdir(APPPATH . 'controllers/' . $directories, 0777, true);
                }
                if (write_file(APPPATH . 'controllers/' . $fileName . '.php', $f)) {
                    echo self::FORMAT_ENTER . 'Controller ' . $className . ' has been created inside ' . APPPATH . 'controllers/' . $directories . '.';
                    return true;
                } else {
                    echo self::FORMAT_ENTER . 'Couldn\'t write Controller.';
                    return false;
                }
            }
        } else {
            echo self::FORMAT_ENTER . 'You need to provide a name for the controller.';
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
        if (isset($model)) {
            $names = $this->setName($model);
            $className = $names['class'];
            $fileName = $names['file'];
            $directories = $names['directories'];
            if (file_exists(APPPATH . 'models/' . $fileName . '.php')) {
                echo self::FORMAT_ENTER . $className . ' Model already exists in the application/models' . $directories . ' directory.';
            } else {
                $f = $this->getTemplate('model');
                if ($f === false) {
                    return false;
                }
                $this->findAndReplace['{{MODEL}}'] = $className;
                $this->findAndReplace['{{MODEL_FILE}}'] = $fileName . '.php';
                $extends = array_key_exists('extend', $arguments) ? $arguments['extend'] : $this->baseModel;
                $extends = in_array(strtolower($extends), array('my', 'ci')) ? strtoupper($extends) : ucfirst($extends);
                $this->findAndReplace['{{MO_EXTENDS}}'] = $extends;
                $f = strtr($f, $this->findAndReplace);
                if (strlen($directories) > 0 && !file_exists(APPPATH . 'models/' . $directories)) {
                    mkdir(APPPATH . 'models/' . $directories, 0777, true);
                }
                if (write_file(APPPATH . 'models/' . $fileName . '.php', $f)) {
                    echo self::FORMAT_ENTER . 'Model ' . $className . ' has been created inside ' . APPPATH . 'models/' . $directories . '.';
                    return true;
                } else {
                    echo self::FORMAT_ENTER . 'Couldn\'t write Model.';
                    return false;
                }
            }
        } else {
            echo self::FORMAT_ENTER . 'You need to provide a name for the model.';
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
        if (isset($view)) {
            $names = $this->setName($view);
            $fileName = strtolower($names['file']);
            $directories = $names['directories'];
            if (file_exists(APPPATH . 'views/' . $fileName . '.php')) {
                echo self::FORMAT_ENTER . $fileName . ' View already exists in the application/views/' . $directories . ' directory.';
            } else {
                $f = $this->getTemplate('view');
                if ($f === false) {
                    return false;
                }
                $this->findAndReplace['{{VIEW}}'] = $fileName . '.php';
                $f = strtr($f, $this->findAndReplace);
                if (strlen($directories) > 0 && !file_exists(APPPATH . 'views/' . $directories)) {
                    mkdir(APPPATH . 'views/' . $directories, 0777, true);
                }
                if (write_file(APPPATH . 'views/' . $fileName . '.php', $f)) {
                    echo self::FORMAT_ENTER . 'View ' . $fileName . ' has been created inside ' . APPPATH . 'views/' . $directories . '.';
                    return true;
                } else {
                    echo self::FORMAT_ENTER . 'Couldn\'t write View.';
                    return false;
                }
            }
        } else {
            echo self::FORMAT_ENTER . 'You need to provide a name for the view file.';
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

            $template = $this->getTemplate('migration');
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
     * @param $str
     *
     * @return array
     */
    private function setName($str)
    {
        $str = strtolower($str);

        if (strpos($str, '.')) {
            $structure = explode('.', $str);
            $className = array_pop($structure);
        } else {
            $structure = array();
            $className = $str;
        }

        $fileName = ucfirst($className);
        $directories = implode('/', $structure);
        $file = $directories . '/' . $fileName;

        return array(
            'file' => $file,
            'class' => $className,
            'directories' => $directories
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
