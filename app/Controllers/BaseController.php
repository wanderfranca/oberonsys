<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

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
    protected $helpers = ['form', 'html', 'text', 'autenticacao' ];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    protected function exibeArquivo(string $destino, string $arquivo){

        $path = WRITEPATH . "uploads/$destino/$arquivo";

        if(is_file($path) === false)
        {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Arquivo $arquivo não encontrado!");


        }

        $fileInfo = new \finfo(FILEINFO_MIME);

        $fileType = $fileInfo->file($path);

        $fileSize = filesize($path);

        header("Content-Type: $fileType");
        header("Content-Length: $fileSize");

        readfile($path);
        exit;

    }

    protected function padronizaImagem600x600(string $caminhoImagem)
    {
        
        //Redimensionar a imagem 600 x 600 para ficar no centro
        service('image')
        ->withFile($caminhoImagem)
        ->fit(600, 600, 'center')
        ->save($caminhoImagem);
        
        // Adicionar uma marca d'água de texto
        \Config\Services::image('imagick')
            ->withFile($caminhoImagem)
            ->text("Oberon", 
            [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => false,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 10,
            ])
            ->save($caminhoImagem);
    }
}
