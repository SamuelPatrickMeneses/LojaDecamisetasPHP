<?php

namespace App\Controllers\Admin;

use App\Entity\Image;
use App\Lib\Flash;
use App\Services\ImageService;
use App\Services\ProductVariantService;
use App\Validators\AdminProductVariantValidator;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AdminProductVariantController extends BaseController
{
    private ProductVariantService $service;
    private ImageService $imageService;
    private AdminProductVariantValidator $validator;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new ProductVariantService();
        $this->imageService = new ImageService();
        $this->validator = new AdminProductVariantValidator($this->params);
    }
    public function post()
    {
        if ($this->validator->isValidCreateProductVariant()) {
            $quantity = intval($this->params['quantity']);
            $price = floatval($this->params['price']) * 100;
            $price = intval($price);
            $color = $this->params['color'];
            $size = $this->params['size'];
            $gender = $this->params['gender'];
            $productId = intval($this->params['productId']);
            $result = $this->service->createProductVariant($productId, $quantity, $price, $size, $color, $gender);
            if ($result) {
                Flash::message('success_message', "create with success!");
                $hasImage = $this->validator->hasImage(
                    fn($error) => Flash::message($error['message'])
                );
                if ($hasImage) {
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
        if ($this->validator->isValidEditProductVariant()) {
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
                $hasImage = $this->validator->hasImage(
                    fn($error) => Flash::message($error['message'])
                );
                if ($hasImage) {
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
        if ($this->validator->isValidId()) {
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
        } elseif ($this->validator->isValidProductId()) {
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
