<!--
<div class="container">
        <div class="display-3 text-center pt-5">POINT MANAGEMENT</div>
        <a href="#" class="btn btn-success mb-3">Manage Points</a>
        <table class="table text-center table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Point</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php
                                      if (isset($_SESSION['user_login'])) {
                                        $users_id = $_SESSION['user_login'];
                                        $statement = $db->query("SELECT * FROM users WHERE user_id = $users_id");
                                        $statement->execute();
                                        $row = $statement->fetch(PDO::FETCH_ASSOC);
                                      }
                
                ?>
                <?php
                
                    $select_stmt = $db->prepare("SELECT * FROM logrobux WHERE rb_uid = $users_id");
                    $select_stmt->execute();
                    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);


                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>

                    <tr>
                        <td><?php echo $row["user"]; ?></td>
                        <td><?php echo $row["rb_name"]; ?></td>

                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
</body> -->