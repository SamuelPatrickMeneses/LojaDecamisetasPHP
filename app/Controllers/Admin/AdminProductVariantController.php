<?php

namespace App\Controllers\Admin;

use App\Entity\Grid;
use App\Entity\Image;
use App\Lib\Flash;
use App\Services\ImageService;
use App\Services\ProductVariantService;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AdminProductVariantController extends BaseController
{
    private ProductVariantService $service;
    private ImageService $imageService;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new ProductVariantService();
        $this->imageService = new ImageService();
    }
    public function isValidId()
    {
        return isset($this->params[':id']) && intval($this->params[':id']) > 0;
    }
    public function isValidGrid()
    {
        return isset($this->params['size'])
        && isset($this->params['color'])
        && isset($this->params['gender'])
        && in_array($this->params['color'], $_SESSION['colorList'])
        && in_array($this->params['size'], Grid::ACEPTED_SIZES)
        && in_array($this->params['gender'], Grid::ACEPTED_GENDERS);
    }
    public function isValidCreateProductVariant()
    {
        return isset($this->params['quantity'])
        && isset($this->params['price'])
        && intval($this->params['price']) > 0 && intval($this->params['quantity']) <= 10000
        && intval($this->params['quantity']) >= 0
        && $this->isValidGrid()
        && isset($this->params['productId']) && intval($this->params['productId']) > 0;
    }
    public function isValidEditProductVariant()
    {
        return isset($this->params['quantity'])
        && isset($this->params['price'])
        && intval($this->params['price']) > 0 && intval($this->params['quantity']) <= 10000
        && intval($this->params['quantity']) >= 0
        && $this->isValidGrid()
        && $this->isValidId();
    }
    public function hasImage()
    {
        if (isset($_FILES['image'])) {
            if (!preg_match('/^.*\.(jpeg|jpg|png)$/', $_FILES['image']['name'])) {
                Flash::message('error_message', 'invalid image type');
                return false;
            }
            if (strlen($_FILES['image']['name']) > 250) {
                Flash::message('error_message', 'too long image name');
                return false;
            }
            if (intval($_FILES['image']['size']) > Image::MAX_ACEPTED_SIZE) {
                Flash::message('error_message', 'invalid image type');
                return false;
            }
            return true;
        }
        return false;
    }
    public function post()
    {
        if ($this->isValidCreateProductVariant()) {
            $quantity = intval($this->params['quantity']);
            $price = intval($this->params['price']) * 100;
            $color = $this->params['color'];
            $size = $this->params['size'];
            $gender = $this->params['gender'];
            $productId = intval($this->params['productId']);
            $result = $this->service->createProductVariant($productId, $quantity, $price, $size, $color, $gender);
            if ($result) {
                Flash::message('success_message', "create with success!");
                if ($this->hasImage()) {
                    $this->imageService->createImage($_FILES['image']['name'], $_FILES['image']['tmp_name'], $productId, $result);
                }
                $this->redirectTo('/admin/products/edit/'. ($this->params['productId'] ?? ''));
            } else {
                Flash::message('error_message', "error on persist");
            }
            $this->redirectTo('/admin/products');
        } else {
            Flash::message('error_message', "invalid values");
            $this->redirectTo($_SESSION['lest_page'] ?? '/admin/products');
        }
    }
    public function edit()
    {

        if ($this->isValidEditProductVariant()) {
            $quantity = intval($this->params['quantity']);
            $price = intval($this->params['price']) * 100;
            $color = $this->params['color'];
            $size = $this->params['size'];
            $gender = $this->params['gender'];
            $productId = intval($this->params[':id']);
            $result = $this->service->updateProductVariant($productId, $quantity, $price, $size, $color, $gender);
            if ($result) {
                Flash::message('success_message', "modified with success!");
                if ($this->hasImage()) {
                    $image = $this->imageService->createImage($_FILES['image']['name'], $_FILES['image']['tmp_name'], $productId, $result);
                }
                $this->redirectTo('/admin/products/edit/'.intval($this->params[':id']));
            } else {
                Flash::message('error_message', "error on persist");
            }
            $this->redirectTo('/admin/products');
        } else {
            Flash::message('error_message', "invalid values");
            $this->redirectTo($_SESSION['lest_page'] ?? '/admin/products');
        }
    }
    public function index()
    {
        $colorList = $this->service->getColorList();
        $_SESSION['colorList'] = $colorList;
        if (isset($this->params[':id'])) {
            if ($this->isValidId()) {
                $productVariant = $this->service->getById(intval($this->params[':id']));
                if (isset($productVariant)) {
                    $images = $this->imageService->imagesByVariant($productVariant->getId());
                        $this->render('admin/editProductVariant', [
                            'productVariant' => $productVariant,
                            'grid' => $productVariant->getGrid(),
                            'colors' => $colorList,
                            'images' => $images
                        ]);
                } else {
                    Flash::message('error_message', "unexistent product");
                    $this->redirectTo('/admin/products');
                }
            } else {
                Flash::message('error_message', "invalid id");
                $this->redirectTo('/admin/products');
            }
        } elseif (isset($this->params['productId']) && intval($this->params['productId']) > 0) {
            $this->render('admin/createProductVariant', [
                'colors' => $colorList,
                'productId' => intval($this->params['productId'])
            ]);
        } else {
            Flash::message('error_message', "invalid id");
            $this->redirectTo('/admin/products');
        }
    }
}
