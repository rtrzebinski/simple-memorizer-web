<div class="panel panel-default">
    <div class="panel-heading">Manage lesson</div>
    <div class="panel-body">
        <div class="col-md-6 no-padding">
            <h4>
                <span class="glyphicon glyphicon-education" aria-hidden="true"></span>
                {{ $lesson->name }}
            </h4>
            <p>
                Number of exercises: 40 </br>
                Number of subscribers: 3 </br>
                Visibility: {{ $lesson->visibility }} </br>
                                <span class="help-block">
                                    Public lessons can be subscribed by other users, but only you can modify them. </br>
                                    Private lessons are only visible for you.
                                </span>
            </p>

        </div>
        <div class="col-md-6 no-padding">
            <p>
                <a href="/lessons/learn" class="btn btn-primary margin-bottom" role="button">
                    <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                    Start learning
                </a>
                <a href="/lessons/edit" class="btn btn-info margin-bottom" role="button">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    Edit lesson
                </a>
                <button class="btn btn-danger margin-bottom" data-title="Delete"
                        data-toggle="modal" data-target="#delete_lesson">
                    Delete lesson
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
                <a href="/lessons/create" class="btn btn-success margin-bottom" role="button">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Create new lesson
                </a>
                <a href="/home" class="btn btn-default margin-bottom">
                    <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
                    Browse lessons
                </a>
            </p>
        </div>
    </div>
</div>


<div class="modal fade" id="delete_lesson" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                <h4 class="modal-title custom_align">Delete</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    Are you sure you want to delete?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Yes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> No
                </button>
            </div>
        </div>
    </div>
</div>
