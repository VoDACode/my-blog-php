<?
namespace providers;
include 'models' . DIRECTORY_SEPARATOR . 'include.php';
use models\UserSessionModel;
use models\UserModel;
use providers\Provider;
class SessionProvider extends Provider
{
    public function addSession(int $userId)
    {
        $token = bin2hex(random_bytes(32));
        $query = "INSERT INTO ".$this->getTableName(__CLASS__)." (userId, token) VALUES ('".$userId."', '".$token."')";
        $this->db->prepare($query)->execute();
        return $token;
    }

    public function getUserIdByToken(string $token)
    {
        $query = "SELECT * FROM ".$this->getTableName(__CLASS__)." WHERE token = '". $token ."'";
        $result = $this->db->querySingle($query);
        if ($result == null) {
            return null;
        }
        return $result['userId'];
    }

    public function getSessionByToken(string $token)
    {
        $query = "SELECT * FROM ".$this->getTableName(__CLASS__)." WHERE token = '". $token ."'";
        $result = $this->db->querySingle($query, true);
        if ($result == null) {
            return null;
        }
        $session = new UserSessionModel($result['id']);
        $session->userId = $result['userId'];
        $session->token = $result['token'];
        $session->createdAt = $result['createdAt'];
        $session->updatedAt = $result['updatedAt'];
        return $session;
    }

    public function authUser(string $userName, string $password){
        $query = "SELECT * FROM users WHERE name = '". $userName ."' AND password = '". $password ."'";
        $result = $this->db->querySingle($query, true);
        var_dump($result);
        if ($result == null) {
            return null;
        }
        $user = new UserModel($result['id'], $result['name'], $result['email'], $result['password'], $result['canPublishPosts'], $result['createdAt']);
        return $user;
    }

    public function deleteSession(int $id)
    {
        $query = "DELETE FROM ".$this->getTableName(__CLASS__)." WHERE id = '". $id ."'";
        $this->db->prepare($query)->execute();
    }
}