TrackDrive API - PHP Class Wrapper
===================================
The wrapper provides a high level of abstraction to allow easy access to TrackDrive API for PHP Developer


TrackDrive API Documentation 
------------
Don't know what fields are required? What options are available? Check out the [API Documentation](http://trackdrive.com/api/docs/1.0/)


Usage
------------
**Create an instance of TrackDrive_API class**
$td = new TrackDrive_API('username','TrackDrive_token');

**Retrieve all records**
```
$td->view('traffic_sources');
$td->view('traffic_sources','',array('order'=>'created_at','order_dir'=>'asc'));
```

**Retrieve a record**
```
$td->view('traffic_sources','xxxxxxxx');
```

**Add a record**
```
$td->add('traffic_sources',array('user_traffic_source_id'=>'FE1','first_name'=>'John','last_name'=>'Doe','company_name'=>'Corporation Inc'));
```

Edit a record
```
$td->edit('traffic_sources',array('user_traffic_source_id'=>'FE1','first_name'=>'Jane','last_name'=>'Smith','company_name'=>'Corporation Inc'));
```

Delete a record
```
$td->delete('traffic_sources','xxxxxxxx');
```

Example
------------
To see the wrapper in action look at `controller.php`. 
For testing it, send GET or POST call to `controller.php` which will return a json object with the status & response from TrackDrive API. 
GET request can only be used to retrieve data. Any Update/Add/Delete must be through a POST request.


Compatibility
------------
Build / Tested on PHP v5.5