<?php

namespace X5\Routes\Lists;

use Argonauts\JsonApiController;
use Argonauts\Routes\ValidationTrait;
use Argonauts\Schemas\Course as CourseSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;
use X5\Schemas\X5List as X5ListSchema;

class AddX5List extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        // if (!$lists = X5List::find($args['id'])) {
        //     throw new RecordNotFoundException();
        // }

        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        // return $this->getContentResponse($lists);

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

        // $x5list = new X5List();
        // $x5list->title = $title;
        // $x5list->range_id = $courseId;
        // // $x5list->range_id = 'a07535cf2f8a72df33c12ddfa4b53dde'; // Test Veranstaltung
        // $x5list->position = '0';
        // $x5list->mkdate = time();
        // $x5list->chdate = $x5list->mkdate;
        // $x5list->visible = false;

        // $x5list->store();

        return $this->createX5List($title, $course_id);
    }

    private function createX5List($title, $range_id)
    {
        return X5List::create(
            [
                'title' => $title,
                'range_id' => $range_id,
                'position' => '0',
                'mkdate' => time(),
                'chdate' => $x5list->mkdate,
                'visible' => false,
            ]
        );
    }
}
