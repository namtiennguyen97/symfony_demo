<?php

/**
 * content actions.
 *
 * @package    tts_nam
 * @subpackage content
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contentActions extends sfActions
{
    const HTTP_Unprocessable_Entity = 422;
    const HTTP_OK = 200;
    protected $customerCate;
    /**
     * Executes sendpost action
     *
     * @param sfRequest $request A request object
     */
    public function executeSendpost(sfWebRequest $request){
        if ($request->isMethod('POST')){
            $newPost = new CustomerCategory();
            $newPost->name = $request->getParameter('title');
            $newPost->save();
            $this->getResponse()->setHttpHeader('Content-type','application/json');

            $dataArr = [
                'statusCode' => self::HTTP_OK,
                'message' => 'Them moi thanh cong',
                'newData'=>[
                    'id' => $newPost->id,
                    'title' => $newPost->name
                ],

                'htmlData' => "<tr class='customer".$newPost->id."'>
                            '<td>$newPost->id</td>'+
                            '<td>$newPost->name</td>'+
                            '<td><a class='btn btn-danger deletePost' data-id='$newPost->id'><i class='fa fa-trash'></i></a></td>'+
                            '<td><a class='btn btn-info customerUpdate' data-id='$newPost->id' data-name='$newPost->name'><i class='fa fa-edit'></i></a></td>'+
</tr>"
            ];
//            $this->setTemplate('show');
          return $this->renderText(json_encode($dataArr));

        }
        $err = [
          'statusCode'=> self::HTTP_Unprocessable_Entity,
          'message' => 'Sai phuong thuc'
        ];
        return $this->renderText(json_encode($err));
//        return $this->redirect('content/show');
    }


    /**
     * Executes sendpost action
     *
     * @param sfRequest $request A request object
     */
    public function executeDeletepost(sfWebRequest $request){
//        Doctrine_Query::create()->
//            delete('CustomerCategory')->from('CustomerCategory')->where('id =?', $request->getParameter('id'))->execute();
        //hoac

        $currentPost =  Doctrine_Core::getTable('CustomerCategory')->find($request->getParameter('id'));
        $currentPost->delete();
        $responseData = [
          'statusCode' => self::HTTP_OK,
          'message' => 'Delete successfully!'
        ];
        return $this->renderText(json_encode($responseData));
    }



    /**
     * Executes updatepost action
     *
     * @param sfRequest $request A request object
     */
    public function executeUpdate(sfWebRequest $request)
    {
//        $currentPost =  Doctrine_Core::getTable('CustomerCategory')
//            ->createQuery('a')
//            ->where('a.id = ?', $request->getParameter('id'))
//            ->fetchOne()
//        ;

        //hoac

        $currentPost =  Doctrine_Core::getTable('CustomerCategory')->find($request->getParameter('id'));
        $currentPost->name = $request->getParameter('name');
        $currentPost->save();

//        $q = Doctrine_Core::getTable('CustomerCategory')->createQuery()->where('id = ?', $request->getParameter('id'))->execute();
        $dataArr = [
            'statusCode' => self::HTTP_OK,
            'message' => 'Updated!',
            'htmlData' => "<tr class='customer".$currentPost->id."'>
                            '<td>$currentPost->id</td>'+
                            '<td>$currentPost->name</td>'+
                            '<td><a class='btn btn-danger deletePost' data-id='$currentPost->id'><i class='fa fa-trash'></i></a></td>'+
                            '<td><a class='btn btn-info customerUpdate' data-id='$currentPost->id' data-name='$currentPost->name'><i class='fa fa-edit'></i></a></td>'+
</tr>"
        ];
        return $this->renderText(json_encode($dataArr));
    }

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
//set default null
    }

    public function executeShow(){
        $this->customerCate = Doctrine::getTable('CustomerCategory')
            ->createQuery()
            ->execute();
    }

    //get one post
    /**
     * Executes getonepost action
     *
     * @param sfRequest $request A request object
     */
    public function executeGetone(sfWebRequest $request){
        $currentPost =  Doctrine_Core::getTable('CustomerCategory')->find(136);
//        $this->getResponse()->setHttpHeader('Content-type','application/json');

        //hoac bo find(id) +
//            ->createQuery('a')
//            ->where('a.id = ?', $request->getParameter('id'))
//            ->fetchOne()


//        $q = Doctrine_Core::getTable('CustomerCategory')->createQuery()->where('id = ?', $request->getParameter('id'))->execute();
        $dataArr = [
            'statusCode' => self::HTTP_OK,
            'data' => [
                'id' => $currentPost->id,
                'name' => $currentPost->name,
            ]
        ];

        return $this->renderText(json_encode($dataArr));
    }

    /**
     * Executes searchpost action
     *
     * @param sfRequest $request A request object
     */
    public function executeSearch(sfWebRequest $request){
        $query = $request->getParameter('search');
        $result =  Doctrine_Core::getTable('CustomerCategory')
            ->createQuery('a')
            ->where('a.name LIKE ?', '%'.$query.'%')
            ->execute()
        ;
        $html = '';
        // search theo name
            if ($query != ''){
                foreach ($result as $value){
                    $html .= "<tr class='customer".$value->id."'>
                            '<td>$value->id</td>'+
                            '<td>$value->name</td>'+
                            '<td><a class='btn btn-danger deletePost' data-id='$value->id'><i class='fa fa-trash'></i></a></td>'+
                            '<td><a class='btn btn-info customerUpdate' data-id='$value->id' data-name='$value->name'><i class='fa fa-edit'></i></a></td>'+
</tr>";
                }
                $responseData = [
                    'statusCode' => self::HTTP_OK,
                    'message' => 'Tim kiem thanh cong',
                    'data' => $html
                ];
                return $this->renderText(json_encode($responseData));
            }

       $nullData =  Doctrine::getTable('CustomerCategory')
            ->createQuery()
            ->execute();

        foreach ($nullData as $value){
            $html .= "<tr class='customer".$value->id."'>
                            '<td>$value->id</td>'+
                            '<td>$value->name</td>'+
                            '<td><a class='btn btn-danger deletePost' data-id='$value->id'><i class='fa fa-trash'></i></a></td>'+
                            '<td><a class='btn btn-info customerUpdate' data-id='$value->id' data-name='$value->name'><i class='fa fa-edit'></i></a></td>'+
</tr>";
        }
        $responseData = [
            'statusCode' => self::HTTP_OK,
            'message' => 'Khong tim kiem gi',
            'data' => $html
        ];
        return $this->renderText(json_encode($responseData));
    }

}
