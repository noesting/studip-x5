<?php

namespace X5\Routes\Lists;

use JsonApi\JsonApiController;
use JsonApi\Routes\ValidationTrait;
use JsonApi\Schemas\Course as CourseSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;
use X5\Schemas\X5List as X5ListSchema;

class X5ItemListAdd extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        // Route not in use?

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $x5list = $this->addX5List($request);

        return $this->getCreatedResponse($x5list);
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

    private function addX5List($request)
    {
        $json = $this->validate($request);

        $title = self::arrayGet($json, 'data.attributes.title');
        $courseId = self::arrayGet($json, 'data.relationships.course.id');

        return $this->createX5List($title, $courseId);
    }

    private function createX5List($title, $range_id)
    {
        $currentTime = time();
        return X5List::create(
            [
                'title' => $title,
                'range_id' => $range_id,
                'position' => '0',
                'mkdate' => $currentTime,
                'chdate' => $currentTime,
                'visible' => false,
            ]
        );
    }
}
