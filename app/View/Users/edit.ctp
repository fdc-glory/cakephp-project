<h2>
    Update Profile
</h2>


<?php 
    if (!empty($this->validationErrors['User'])): ?>
        <div class="error-message">
            <strong>Please fix the following errors:</strong>
            <ul>
                <?php foreach ($this->validationErrors['User'] as $fieldErrors): ?>
                    <?php if (is_array($fieldErrors)): ?>
                        <?php foreach ($fieldErrors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><?= $fieldErrors ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
<?php endif; ?>

<img id="image-preview" src="#" alt="Preview" style="max-width: 100%; max-height: 150px; display: none;">

<?php
    echo $this->Form->create("User", [
        'type' => 'file',
        'url' => ['controller' => 'users', 'action'=> 'update']
    ]); 
    echo $this->Form->file('profile_img', ['type' => 'file', 'id' => 'img_form']); 
    echo $this->Form->input("user_name"); 
    echo $this->Form->input("email"); 
    echo $this->Form->input("password", ['type' => 'password', 'value' => '', 'placeholder' => 'Enter your password']); 
    echo $this->Form->input("birthdate", ['id' => 'UserBirthdate']); //jquery 
    echo $this->Form->radio('gender', ['male' => 'Male', 'female' => 'Female']); 
    echo $this->Form->textarea("hubby"); 
    echo $this->Form->end("Update"); 
?>

<!-- Image preview section -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#img_form').change(function () {
            var file = this.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image-preview').attr('src', e.target.result).show(); // Show the image preview
                };

                reader.readAsDataURL(file);
            }
        });

        //birthdate datepicker - not functioning
        // $("#UserBirthdate").datepicker({
        //     dateFormat: "yy-mm-dd",  // Set the desired date format
        //     changeYear: true,        // Allow changing the year
        //     yearRange: "1900:+0",    // Set the range of years
        // });
    });
</script>


<style>

    #image-preview {
        max-width: 100%;
        max-height: 100px;
        float: left;
        margin-right: 10px;
    }

    #img_form {
        float: left;
    }
</style>

