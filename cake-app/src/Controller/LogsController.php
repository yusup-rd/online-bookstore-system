<?php
namespace App\Controller;

use App\Model\Entity\User;

/**
 * Logs Controller
 *
 * @property \App\Model\Table\LogsTable $Logs
 *
 * @method \App\Model\Entity\Log[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LogsController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg');
    }

    /**
     * isAuthorized method
     *
     * @param array|null $user User
     * @return bool
     */
    public function isAuthorized($user)
    {
        return User::isAdmin($user['role']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $users = $this->Logs->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->where(['status' => true])->toArray();

        $users['public'] = 'Public';

        $queryParams = $this->request->getQueryParams();

        if (isset($queryParams['user_id']) && $queryParams['user_id'] === 'public') {
            $queryParams['user_id'] = 'public';
        }

        $this->paginate = [
            'contain' => ['Users'],
            'order' => ['Logs.timestamp' => 'DESC'],
            'finder' => 'search',
            'search' => $queryParams,
        ];
        $logs = $this->paginate($this->Logs);

        $this->set(compact('logs', 'users'));
    }
}
