
<form action = "/addPost" method="POST" class="addPost-form" enctype="multipart/form-data">
    
    <h2 class="addPost-title"> Add new article </h2>
    
    <table cellspacing = '10' class="addPost-table">
        <tr>
            <td> 
                <label for="title" class="addPost-field-title">
                    <span>Title of the article:</span> 
                    <input type="text" id="title" name="title" class="addPost-input" placeholder="Title ..." required />
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
            <td align="center"> <input type="submit" name="add-post-submit" value="Add the article" /> </td>
        </tr>
        <tr>
            <td class="addPost-message"> <?= $data['addPost_message']??'' ?> </td>
        </tr>

    </table>
    
</form>