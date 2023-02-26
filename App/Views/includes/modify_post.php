
<form action = "/modifyPost?modifyID=<?=$data['modify_article_id']?>" method="POST" class="addPost-form" enctype="multipart/form-data">
    
    <h2 class="addPost-title"> Modify the article </h2>
    
    <table cellspacing = '10' class="addPost-table">
        <tr>
            <td> 
                <label for="title" class="addPost-field-title">
                    <span>Title of the article:</span> 
                    <input type="text" id="title" name="title" class="addPost-input modifyPost-input" placeholder="<?=$data['modified_article']['title']?>" required />
                </label>
            </td>
        </tr>
        <tr>
            <td> 
                <label for="image" class="addPost-field-title"> 
                    <span>Background-image :</span> 
                    <input type="file" id="image" name="image" class="addPost-input-image" />
                </label>
            </td>
        </tr>
        <tr>
            <td> 
                <label for="content">
                    <textarea name="content" id="content" required> </textarea> 
                    <script>CKEDITOR.replace('content')</script>
                </label>
            </td>
        </tr>
        <tr>
            <td> 
                <label for="is_public" class="addPost-field-title" > 
                    <span>Public of the article ? :</span> 
                    <input type="checkbox" id="is_public" name="is_public" value="1" /> <span class="addPost-field-title" > public </span>
                </label>
            </td>
        </tr>
        <tr>
            <td align="center"> <input type="submit" name="modify-post-submit" value="Modify" /> </td>
        </tr>
        <tr>
            <td class="addPost-message"> <?= $data['modifyPost_message']??'' ?> </td>
        </tr>

    </table>
    
</form>