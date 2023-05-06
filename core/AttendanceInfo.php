<?

namespace core;

use app\providers\Statistics;

class AttendanceInfo
{
    static public function writeGeneral()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $uri = $_SERVER['REQUEST_URI'];
        $user = $_SERVER['PHP_AUTH_USER'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $ref = $_SERVER['HTTP_REFERER'];
        $dtime = date('r');

        if (!$ref) {
            $ref = "No";
        }
        if (!$user) {
            $user = "No";
        }

        $entry_line = "$dtime - IP: $ip | Agent: $agent | URL: $uri | Referrer:$ref | Username: $user\n";
        $fp = fopen($_ENV['ROOT_PATH'] . 'info' . DIRECTORY_SEPARATOR . 'logs.txt', "a");
        fputs($fp, $entry_line);
        fclose($fp);
    }

    static public function countUser()
    {
        /*if (
            (new Statistics)->select('username')->where('username = :u', [
                ':u' => $_SESSION['user']
            ])->run()
        ) {
            $count = (new Statistics)->select('count')->where('username = :u', [
                ':u' => $_SESSION['user']
            ])->run()[0]['count'];
            (new Statistics)->update([
                'date' => date('Y-m-d', time()),
                'count' => $count + 1
            ])->where('username = :u', [
                    ':u' => $_SESSION['user']
                ])->run();
        } else {
            (new Statistics)->insert([
                'username' => $_SESSION['user'],
                'last_visit_date' => date('Y-m-d', time()),
                'count' => 1
            ])->run();
        }*/

        $visitData = (new Statistics)->select()->run();
        $visitInfo = '';

        /*foreach ($visitData as $visit) {
            $visitInfo +=
                'User: ' . $visit['username'] .
                ' | Last visit: ' . $visit['last_visit_date'] .
                ' | Count: ' . $visit['count'] . "\n";
        }*/

        $fileDirectory = $_ENV['ROOT_PATH'] . 'info' . DIRECTORY_SEPARATOR . 'visits.txt';

        file_put_contents($fileDirectory, "");
        file_put_contents($fileDirectory, $visitInfo);
    }
}