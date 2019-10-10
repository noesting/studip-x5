<?php

namespace X5\Routes\Lists;

use JsonApi\JsonApiController;
use JsonApi\Routes\TimestampTrait;
use JsonApi\Routes\ValidationTrait;
use JsonApi\Schemas\Course as CourseSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;
use X5\Schemas\X5List as X5ListSchema;

class X5ListUpdate extends JsonApiController
{
    use ValidationTrait, TimestampTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        global $perm;

        if (!$x5list = X5List::find($args['id'])) {
            throw new RecordNotFoundException();
        }

        if (!$perm->have_studip_perm('dozent', $x5list->course->id)) {
            throw new AuthorizationFailedException();
        };     

        $result = $this->updateX5List($request, $x5list);

        return $this->getCreatedResponse($result);
    }

    public function updateX5List($request, $x5list)
    {
        $json = $this->validate($request);

        $title = self::arrayGet($json, 'data.attributes.title');
        $release_date_string = self::arrayGet($json, 'data.attributes.releaseDate', '');
        $release_date = self::fromISO8601($release_date_string)->getTimestamp();

        $x5list->title = $title;
        $x5list->position = self::arrayGet($json, 'data.attributes.position');
        $x5list->visible = self::arrayGet($json, 'data.attributes.visible');
        // $x5list->release_date = self::arrayGet($json, 'data.attributes.releaseDate');
        $x5list->release_date = $release_date;
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

        //Attribute: release date
        if (!self::isValidTimestamp(self::arrayGet($json, 'data.attributes.releaseDate', ''))) {
            return '`releaseDate` (' . self::arrayGet($json, 'data.attributes.releaseDate', '') . ') is not a valid Timestamp. ';
        }

        // Relationship: course
        if (!$this->validateResourceObject($json, 'data.relationships.course', CourseSchema::TYPE)) {
            return 'Missing `course` relationship';
        }
    }
}
