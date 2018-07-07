
/**
 * Loads and displays the image from the given file
 * @param input image file to use as a profile picture
 */
function renderImage(input)
{
    var imagePreview = document.getElementById("imagePreview");

    if(input.files)
    {
        var reader = new FileReader();

        var fileName = input.files[0].name;

        if(canRender(fileName))
        {
            imagePreview.innerHTML = '<img src="" class="img-fluid rounded"  id="profilePicture" height="200" width="200" style="image-orientation: from-image">';

            reader.onload = function (e)
            {
                $('#profilePicture').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }

        else
        {
            imagePreview.innerHTML = '<div class="alert alert-warning" role="alert"> The image does not have a valid file format</div>';
        }
    }
}

/**
 *
 * @param fileName the name of the image file to upload
 * @returns true if the image has an acceptable extension and filename, false otherwise
 */
function canRender(fileName)
{

    var fileExtension;

    var lastPeriod = fileName.lastIndexOf('.');

    if(lastPeriod > 0)
    {
        fileExtension = fileName.substring(lastPeriod + 1).toLowerCase();

        switch(fileExtension)
        {
            case "bmp": return true;

            case "gif": return true;

            case "jpg": return true;

            case "jpeg": return true;

            case "jif": return true;

            case "jfif": return true;

            case "png": return true;

            case "svg": return true;

            case "tif": return true;

            case "tiff": return true;

            default: false;
        }

    }

    return (false);
}
