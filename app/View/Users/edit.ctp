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

<?= $this->Form->create("User", ['type' => 'file']); ?>


    <img id="image-preview" src="#" alt="Preview" style="max-width: 100%; max-height: 150px; display: none;">

<?= $this->Form->file('profile_img', ['type' => 'file', 'id' => 'img_form']); ?>


<?= $this->Form->input("user_name"); ?>
<?= $this->Form->input("email"); ?>
<?= $this->Form->input("password", ['type' => 'password', 'value' => '', 'placeholder' => 'Enter your password']); ?>
<?= $this->Form->input("birthdate", ['id' => 'UserBirthdate']); //jquery ?>
<?= $this->Form->radio('gender', ['male' => 'Male', 'female' => 'Female']); ?>
<?= $this->Form->textarea("hubby"); ?>
<?= $this->Form->end("Update"); ?>

<!-- Image preview section -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#UserProfileImg').change(function () {
            var file = this.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image-preview').attr('src', e.target.result).show(); // Show the image preview
                };

                reader.readAsDataURL(file);
            }
        });

        //birthdate datepicker
        $("#UserBirthdate").datepicker({
            dateFormat: "yy-mm-dd",  // Set the desired date format
            changeYear: true,        // Allow changing the year
            yearRange: "1900:+0",    // Set the range of years
            // Add more options as needed
        });
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
