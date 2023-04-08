<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;
use App\Models\MenuModel;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['cookie', 'date', 'security'];
    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */


    protected array $data = [];
    protected UserModel $userModel;
    protected array|null $user = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
        $this->encrypter = \Config\Services::encrypter();
        $this->userModel = new UserModel();
        $this->user = $this->userModel->getUser(id_user: (int)session()->get('id_user'));
        $this->data = [
            'breadcrumb' => [],
            'currentUser' => $this->user
        ];
    }
}
