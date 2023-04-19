<?
namespace core\interfaces;

interface IAuthUser{
    public function check();
    public function login($login, $password);
    public function logout();
    public function get();
}