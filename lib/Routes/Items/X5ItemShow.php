<?php

namespace X5\Routes\Items;

use JsonApi\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5ItemDummy;

class X5ItemShow extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {

        if (!$item = $this->find($args['id'])) {
            throw new RecordNotFoundException();
        }

        if (!$this->getUser($request)) {
            throw new AuthorizationFailedException();
        }

        return $this->getContentResponse($item);
        // return $item;
    }

    private function find($id)
    {
        $dataSTR = file_get_contents(__DIR__ . '/items.json');
        $dataJSON = json_decode($dataSTR, true);

        for ($i = 0; $i < sizeof($dataJSON['recommendations']); $i++) {
            if ($dataJSON['recommendations'][$i]['id'] === $id) {
                // return json_encode($dataJSON['recommendations'][$i]);
                return new X5ItemDummy($dataJSON['recommendations'][$i]);
            }
        }

        return null;
    }
}
