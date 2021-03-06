<?php

    class socket extends ZXC_controller implements controller {

        public function __call($name, $arguments) {
            parent::__call($name, $arguments);
        }
        public function __construct() {
            parent::__construct();
        }
        
        public function open() {

            if($this->config->server_websocket) {

                if($this->config->remote_server == "windows") {
                    if($this->config->php_exe_path !== "") {
    
                        //Disabled windows
                        $command_script = "start \"websocket\" {$this->config->php_exe_path} {$this->config->server_file_name}";
                        $a = shell_exec ($command_script);
                        $command_script = "echo $! > pids/pid_proccess.txt";
                        shell_exec ($command_script);
    
                    } else {
    
                        //Disabled windows
                        $command_script = "where php.exe";
                        $php_exe_path = trim(preg_replace('/\s\s+/', ' ', shell_exec ($command_script)));
    
                        //Get path
                        $command_script = "where websocket/$this->config->server_file_name";
                        $server_php_path = trim(preg_replace('/\s\s+/', ' ', shell_exec ($command_script)));
    
                        //Move to path
                        $command_script = "cd $server_php_path";
                        shell_exec($command_script);
    
                        $command_script = "start \"websocket\" {$php_exe_path} {$this->config->server_file_name}";
                        $a = shell_exec ($command_script);
                        $command_script = "echo $! > pids/pid_proccess.txt";
                        shell_exec ($command_script);
    
                    }
    
                } else if($this->config->remote_server == "linux" || $this->config->remote_server == "centos") {
    
                    $command_script = "nohup php ".$this->config->server_file_name." > logs/nohup.log 2>&1 &";
                    shell_exec ($command_script);
                    $command_script = "echo $! > pids/pid_proccess.txt";
                    shell_exec ($command_script);
    
                } else {
                    die("Server is not supported.");
                }
            }
        }

        public function close() {
            
            if($this->config->server_websocket) {
                if($this->config->remote_server == "windows") {
                    $command_script = "taskkill /FI \"WindowTitle eq websocket*\" /T /F";
                    shell_exec ($command_script);
                } else if($this->config->remote_server == "linux" || $this->config->remote_server == "centos") {
                    $command_script = "kill -9 `cat pids/pid_proccess.txt`";
                    shell_exec ($command_script);
                }
            }
        }
    }