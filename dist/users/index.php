<?php @include '../_includes/pageSetup.php'; ?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Users</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-hover table-striped l2sr-table">
                    <thead class="font-weight-bold">
                    <tr>
                        <th>Id</th>
                        <th>First</th>
                        <th>Last</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date Created</th>
                    </tr>
                    </thead>
                    <tbody id="user-table-body">
                    <tr>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="font-italic">User configuration or removal tools to be added in future iterations of the
                    project.</p>
            </div>
        </div>
    </div>

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Invites</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-hover table-striped l2sr-table">
                    <thead class="font-weight-bold">
                    <tr>
                        <th>Access Code</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>User Accepted</th>
                        <th>Date Accepted</th>
                    </tr>
                    </thead>
                    <tbody id="invite-table-body">
                    <tr>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="font-italic">Invite configuration or removal tools to be added in future iterations of the
                    project.</p>
                <button type="button" id="send-invite-btn" class="btn btn-primary "
                        data-toggle="modal" data-target="#send-invite-modal">Send Invite
                </button>
                <!-- Modal -->
                <div class="modal fade" id="send-invite-modal" tabindex="-1" role="dialog"
                     aria-labelledby="Send Invite">
                    <div class="modal-dialog l2sr-mtop-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Send Invite</h4>
                            </div>
                            <form id="invite-form">
                                <div class="modal-body">
                                    <fieldset id="form-fieldset">
                                        <div class="form-group col-lg-12">
                                            <label for="inputEmail" class="control-label">Email</label>
                                            <div>
                                                <input type="email" class="form-control" name="email" id="inputEmail"
                                                       value="">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/users.js" type="text/javascript"></script>

</body>
</html>
