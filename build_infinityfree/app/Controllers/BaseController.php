<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserActivityModel;

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
abstract class BaseController extends Controller
{
   /**
    * Instance of the main Request object.
    *
    * @var CLIRequest|IncomingRequest
    */
   protected $request;

   /**
    * An array of helpers to be loaded automatically upon
    * class instantiation. These helpers will be available
    * to all other controllers that extend BaseController.
    *
    * @var array
    */
   protected $helpers = [];

   /**
    * Be sure to declare properties for any property fetch you initialized.
    * The creation of dynamic property is deprecated in PHP 8.2.
    */

   protected $session;

   protected $generalSettings;

   /**
    * Constructor.
    */
   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
   {
      // Do Not Edit This Line
      parent::initController($request, $response, $logger);

      // Preload any models, libraries, etc, here.

      $this->session = \Config\Services::session();
      $schoolConfigurations  = new \Config\School();
      $this->generalSettings = $schoolConfigurations::$generalSettings;

      // Passing global variable to views
      $view = \Config\Services::renderer();
      $view->setData(['generalSettings' => $this->generalSettings]);

      // Track user activity (only when user is logged in)
      $this->trackUserActivity();
   }

   /**
    * Track user activity for realtime online status
    */
   protected function trackUserActivity(): void
   {
      try {
         helper('user');
         $u = user();
         if (!empty($u)) {
            $activityModel = new UserActivityModel();
            
            // Get nama lengkap dari guru/siswa jika ada
            $namaLengkap = null;
            if (!empty($u->id_guru)) {
               $guru = (new \App\Models\GuruModel())->find($u->id_guru);
               if ($guru) $namaLengkap = $guru['nama_guru'];
            }

            $role = intval($u->is_superadmin ?? 3);
            $activityModel->updateActivity(
               userId: $u->id,
               username: $u->username ?? 'unknown',
               role: $role,
               namaLengkap: $namaLengkap,
            );
         }
      } catch (\Throwable $e) {
         // Jangan biarkan error tracking mengganggu aplikasi utama
         log_message('error', 'Activity tracking error: ' . $e->getMessage());
      }
   }
}
