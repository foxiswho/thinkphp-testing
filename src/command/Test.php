<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace foxiswho\testing\command;

use PHPUnit\TextUI\Command as PHPUnit_TextUI_Command;
use PHPUnit\Util\Blacklist as PHPUnit_Util_Blacklist;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Env;
use think\facade\Session;
use think\Loader;

class Test extends Command
{
    public function configure()
    {
        $this->setName('unit')->setDescription('phpunit')->ignoreValidationErrors();
    }

    public function execute(Input $input, Output $output)
    {
        //注册命名空间
        Loader::addNamespace('tests', Env::get('root_path') . 'tests');

        Session::init();
        $argv = $_SERVER['argv'];
        array_shift($argv);
        array_shift($argv);
        array_unshift($argv, 'phpunit');
        PHPUnit_Util_Blacklist::$blacklistedClassNames = [];

        $code = (new PHPUnit_TextUI_Command())->run($argv, false);

        return $code;
    }

}
