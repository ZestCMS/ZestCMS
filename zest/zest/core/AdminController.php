<?php

/**
 * AdminController
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Core;

/**
 * Abstract Controller overide by Admin Controllers
 */
abstract class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true)
        {
            $this->getZest()->call404Error();
        }
    }
}
