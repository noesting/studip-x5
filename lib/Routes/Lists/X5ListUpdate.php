<?php

namespace X5\Routes\Lists;

use Argonauts\JsonApiController;
use Argonauts\Routes\ValidationTrait;
use Argonauts\Schemas\Course as CourseSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;
use X5\Schemas\X5List as X5ListSchema;

class X5ListUpdate extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        if (!$x5list = X5List::find($args['id'])) {
            throw new RecordNotFoundException();
        }

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $result = $this->updateX5List($request, $x5list);

        return $this->getCreatedResponse($result);
    }

    public function updateX5List($request, $x5list)
    {
        $json = $this->validate($request);

        $title = self::arrayGet($json, 'data.attributes.title');

        $x5list->title = self::arrayGet($json, 'data.attributes.title');
        $x5list->position = self::arrayGet($json, 'data.attributes.position');
        $x5list->visible = self::arrayGet($json, 'data.attributes.visible');
        $x5list->release_date = self::arrayGet($json, 'data.attributes.releaseDate');
        $x5list->chdate = time();

        $x5list->store();
        return $x5list;
    }

    protected function validateResourceDocument($json, $data)
    {
        if (!$this->validateResourceObject($json, 'data', X5ListSchema::TYPE)) {
            return 'Missing primary resource object.';
        }

        // Attribute: title
        if (!$title = self::arrayGet($json, 'data.attributes.title', '')
            || !mb_strlen(trim($title))) {
            return '`title` must not be empty.';
        }

        // Relationship: course
        if (!$this->validateResourceObject($json, 'data.relationships.course', CourseSchema::TYPE)) {
            return 'Missing `course` relationship';
        }
    }
}
