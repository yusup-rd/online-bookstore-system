<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Network\Exception\InternalErrorException;
use Cake\ORM\TableRegistry;

/**
 * Logger component
 */
class LoggerComponent extends Component
{
    /**
     * Startup method
     *
     * @param \Cake\Event\Event $event Event
     * @return void
     */
    public function startup(Event $event)
    {
        $controller = $event->getSubject();
        $userId = !empty($controller->Auth->user('id')) ? $controller->Auth->user('id') : null;
        $url = $controller->request->getRequestTarget();
        $ipAddress = $controller->request->clientIp();

        $now = Time::now()->i18nFormat('yyyy-MM-dd HH:mm:ss');

        try {
            $logsTable = TableRegistry::getTableLocator()->get('Logs');
            $log = $logsTable->newEntity([
                'user_id' => $userId,
                'url' => $url,
                'ip_address' => $ipAddress,
                'created' => $now,
            ]);
            $logsTable->save($log);
        } catch (\Exception $e) {
            Log::error('Unable to log user action: ' . $e->getMessage());
            throw new InternalErrorException('Unable to log user action.');
        }
    }
}
