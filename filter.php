<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location">
        
        <div>
            <button type="button" onclick="applyFilter('vintage')">Vintage</button>
            <button type="button" onclick="applyFilter('lomo')">Lomo</button>
            <button type="button" onclick="applyFilter('clarity')">Clarity</button>
            <button type="button" onclick="applyFilter('sinCity')">Sin City</button>
        </div>
        
        <canvas id="canvas"></canvas>
        
        <button type="submit">Upload</button>
    </form>
    
    <script>
        const imageInput = document.getElementById('image');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                }
                img.src = event.target.result;
            }

            reader.readAsDataURL(file);
        });

        function applyFilter(filter) {
            Caman('#canvas', function () {
                this.revert();
                this[filter]().render();
            });
        }
    </script>
</body>
</html>
