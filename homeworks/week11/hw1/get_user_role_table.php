<?php
  require_once("util.php");
  function get_user_role_row($row) {
    if ($row['id'] === "0") {
      echo <<<ROW
      <tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['nickname']}</td>
        <td>{$row['role_name']}</td>
        <td>{$row['can_post']}</td>
        <td>{$row['edit_range']}</td>
        <td>{$row['del_range']}</td>
      </tr>
ROW;
      return;
    }
    $selected_attr_map = ["", "", "", "", "", ""];
    $selected_attr_map[$row["role_id"]] = "selected";
    echo <<<ROW
      <tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['nickname']}</td>
        <td>
          <form method="POST" action="cmd_set_user_role.php" class="update-role-form">
            <select name="role">
              <option value="2" {$selected_attr_map[2]}>guest</option>
              <option value="4" {$selected_attr_map[4]}>banned</option>
              <option value="3" {$selected_attr_map[3]}>user</option>
              <option value="5" {$selected_attr_map[5]}>editor</option>
              <option value="1" {$selected_attr_map[1]}>admin</option>
            </select>
            <input type="hidden" name="user_id" value="{$row['id']}">
            <input type="submit" value="update">
          </form>
        </td>
        <td>{$row['can_post']}</td>
        <td>{$row['edit_range']}</td>
        <td>{$row['del_range']}</td>
      </tr>
ROW;
  }
  function get_user_role_table() {
    $result = get_user_role_info();
    echo <<<TABLE_START
    <table border=1>
      <tr>
        <th>user_id</th>
        <th>username</th>
        <th>nickname</th>
        <th>role</th>
        <th>can_post</th>
        <th>edit_range</th>
        <th>del_range</th>
      </tr>
TABLE_START;
    while($row = $result->fetch_assoc()) {
      get_user_role_row($row);
    }
    echo "    </table>";
    return;
  }
  get_user_role_table();
?>