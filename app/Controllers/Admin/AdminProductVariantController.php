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
        return isset($this->params[':variantId']) && intval($this->params[':variantId']) > 0;
    }
    public function isValidProductId()
    {
        return isset($this->params['productId']) && intval($this->params['productId']) > 0;
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
        && $this->isValidProductId();
    }
    public function isValidEditProductVariant()
    {
        return $this->isValidProductId()
        && isset($this->params['quantity'])
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
                return false;
            }
            if (strlen($_FILES['image']['name']) > 250) {
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
                    $this->imageService->createImage(
                        $_FILES['image']['name'],
                        $_FILES['image']['tmp_name'],
                        $productId,
                        $result
                    );
                }
                $this->redirectTo('/admin/products/edit/' . ($productId ?? ''));
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
            $variantId = intval($this->params[':variantId']);
            $productId = intval($this->params['productId']);
            $result = $this->service->updateProductVariant($variantId, $quantity, $price, $size, $color, $gender);
            if ($result) {
                Flash::message('success_message', "modified with success!");
                if ($this->hasImage()) {
                    $this->imageService->createImage(
                        $_FILES['image']['name'],
                        $_FILES['image']['tmp_name'],
                        $productId,
                        $variantId
                    );
                }
                $this->redirectTo('/admin/products/' . $productId);
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
        if ($this->isValidId()) {
                $variantId = intval($this->params[':variantId']);
                $productVariant = $this->service->getByIdWithImages($variantId);
            if (isset($productVariant)) {
                    $this->render(
                        'admin/editProductVariant',
                        [
                            'productVariant' => $productVariant,
                            'grid' => $productVariant->getGrid(),
                            'colors' => $colorList,
                            'images' => $productVariant->getImages()
                        ]
                    );
            } else {
                Flash::message('error_message', "unexistent product");
                $this->redirectTo('/admin/products');
            }
        } elseif ($this->isValidProductId()) {
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
