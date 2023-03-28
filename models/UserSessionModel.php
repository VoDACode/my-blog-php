<?
namespace models;
use models\Model;
class UserSessionModel extends Model {
    public $userId;
    public $token;
    public $createdAt;
    public $updatedAt;
}