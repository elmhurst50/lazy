<?php

namespace samjoyce777\lazy;

use Illuminate\Routing\Controller;
use samjoyce777\album\Facades\Album;

/**
 * Class ImageController
 * @package samjoyce777\lazy
 */
class ImageController extends Controller
{

    /**
     * Returns the image required to fit element
     * @return mixed
     */
    public function ajax(){
        $data = \Input::get('data');

        $response = new \stdClass();

        $response->image = Album::getNearestImage('cushion.jpg', $data["element_width"]);

        return \Response::json($response);
    }
}