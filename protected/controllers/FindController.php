<?php
class FindController extends Controller
{
  /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';
    /**
     * @return array action filters
     */
    public function filters()
    {
            return array();
    }
 
    // Actions
    public function actionList()
    {
      // Get the respective model instance
      // URL http://localhost/~vgaur/fiindme/index.php/find/deal
      switch($_GET['model'])
	{
        case 'deal':
	  $criteria = new CDbCriteria();
	  $criteria->limit=10;
	  $models = Deal::model()->findAll($criteria);
	  break;
        default:
	  // Model not implemented error
	  $this->_sendResponse(501, sprintf(
					    'Error: Mode <b>list</b> is not implemented for model <b>%s</b>',
					    $_GET['model']) );
	  Yii::app()->end();
	}

      // Did we get some results?
      if(empty($models)) {
        // No
        $this->_sendResponse(200, 
			     sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
      } else {

        // Prepare response
        $rows = array();
        foreach($models as $model)
	  $rows[] = $model->attributes;
        // Send the response
        $this->_sendResponse(200, CJSON::encode($rows));
      }
    }//end actionList

    //GET: To view the deals in specific zip code
    //URL http://localhost/~vgaur/fiindme/index.php/find/deal/94568
    public function actionView()
    {
      // Check if id was submitted via GET
      if(!isset($_GET['id']))
        $this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
 
      switch($_GET['model'])
	{
	  // Find respective model    
        case 'deal':
	  $models = Deal::model()->findByZipCode($_GET['id']);
	  break;
        default:
	  $this->_sendResponse(501, sprintf(
					    'Mode <b>view</b> is not implemented for model <b>%s</b>',
					    $_GET['model']) );
	  Yii::app()->end();
	}
      // Did we find the requested models? If not, raise an error
      if(empty($models))
        $this->_sendResponse(404, 'No Item found with id '.$_GET['id']);
      else{
	// Prepare response
        $rows = array();
        foreach($models as $model){
	  $rows[] = $model;
	}
        // Send the response
        $this->_sendResponse(200, CJSON::encode($rows));
      }
    }

    public function actionCreate()
    {
    }

    //PUT: update confirm the deal. change the status to sold
    // Return the random generated code for the user and save in the
    // tbl_deal_business_user to verify
    // URL http://localhost/~vgaur/fiindme/index.php/find/deal/update/id
    public function actionUpdate()
    {
      //Parse the PUT parameters
      $json = file_get_contents('php://input');

      $put_vars = CJSON::decode($json,true);  //true means use associative array
      
       switch($_GET['model'])
    {
        // Find respective model
        case 'deal':
            $model = Deal::model()->findByPk($_GET['id']);                    
            break;
        default:
            $this->_sendResponse(501, 
                sprintf( 'Error: Mode <b>update</b> is not implemented for model <b>%s</b>',
                $_GET['model']) );
            Yii::app()->end();
    }
    // Did we find the requested model? If not, raise an error
    if($model === null)
        $this->_sendResponse(400, 
                sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
                $_GET['model'], $_GET['id']) );
 
    // Try to assign PUT parameters to attributes
    /*foreach($put_vars as $var=>$value) {
        // Does model have this attribute? If not, raise an error
        if($model->hasAttribute($var))
            $model->$var = $value;
        else {
            $this->_sendResponse(500, 
                sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>',
                $var, $_GET['model']) );
        }
	}*/
    // Set the Deal status to "SOLD"
    $model->status = "SOLD";

    $deal_merchant = array();
    $user_code = rand(100,999);
    echo $user_code;
    echo $merchant_code;
    $merchant_code = rand(100,999);
    $deal_merchant[0] = $user_code;

    //SQL Query
    $sql = "INSERT INTO tbl_deal_business_user (deal_id_fk,merchant_id_fk,user_code,merchant_code,status) VALUES (:deal_id,:merchant_id,:user_code,:merchant_code,:status)";

    $command = Yii::app()->db->createCommand(sql);
    $command->bindValue(":deal_id",$model->deal_id, PDO::PARAM_INT);
    $command->bindValue(":merchant_id",$model->merchant_id_fk->merchant_id, PDO::PARAM_INT);
    $command->bindValue(":user_code",$user_code, PDO::PARAM_INT);
    $command->bindValue(":user_code",$merchant_code, PDO::PARAM_INT);
    $command->bindValue(":status",$model->status, PDO::PARAM_STR);
    $command->execute;

    // Try to save the model
    if($model->save())
        $this->_sendResponse(200, CJSON::encode($deal_merchant));
    else
        // prepare the error $msg
        // see actionCreate
        // ...
        $this->_sendResponse(500, $msg );
    }
    public function actionDelete()
    {
    }

    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
      // set the status
      $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
      header($status_header);
      // and the content type
      header('Content-type: ' . $content_type);
 
      // pages with body are easy
      if($body != '')
	{
	  // send the body
	  echo $body;
	}
      // we need to create the body if none is passed
      else
	{
	  // create some body messages
	  $message = '';
 
	  // this is purely optional, but makes the pages a little nicer to read
	  // for your users.  Since you won't likely send a lot of different status codes,
	  // this also shouldn't be too ponderous to maintain
	  switch($status)
	    {
            case 401:
	      $message = 'You must be authorized to view this page.';
	      break;
            case 404:
	      $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
	      break;
            case 500:
	      $message = 'The server encountered an error processing your request.';
	      break;
            case 501:
	      $message = 'The requested method is not implemented.';
	      break;
	    }
 
	  // servers don't always have a signature turned on 
	  // (this is an apache directive "ServerSignature On")
	  $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];
 
	  // this should be templated in a real-world solution
	  $body = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
</head>
<body>
    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
    <p>' . $message . '</p>
    <hr />
    <address>' . $signature . '</address>
</body>
</html>';
 
	  echo $body;
	}
      Yii::app()->end();
    }

    private function _getStatusCodeMessage($status)
    {
      // these could be stored in a .ini file and loaded
      // via parse_ini_file()... however, this will suffice
      // for an example
      $codes = Array(
		     200 => 'OK',
		     400 => 'Bad Request',
		     401 => 'Unauthorized',
		     402 => 'Payment Required',
		     403 => 'Forbidden',
		     404 => 'Not Found',
		     500 => 'Internal Server Error',
		     501 => 'Not Implemented',
		     );
      return (isset($codes[$status])) ? $codes[$status] : '';
    }
}


?>