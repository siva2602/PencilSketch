<!DOCTYPE html>
<html>

<head>
    <title>Upload Your Photo</title>
    <style>
        #image {
            display: none;
        }

        .picture {
            width: 400px;
            aspect-ratio: 16/9;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            border: 2px dashed currentcolor;
            cursor: pointer;
            font-family: sans-serif;
            transition: color 300ms ease-in-out, background 300ms ease-in-out;
            outline: none;
            overflow: hidden;
        }

        .picture:hover {
            color: #777;
            background: #ccc;
        }

        .picture:active {
            border-color: turquoise;
            color: turquoise;
            background: #eee;
        }

        .picture:focus {
            color: #777;
            background: #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .picture__img {
            max-width: 100%;
        }

        .button {
            background-color: #04AA6D;
            /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px
        }
    </style>
</head>

<body>
    @if (!$isTrue)
    <h1 style="text-align: center">Pencil Sketch a Photo</h1>
    <div style="display: flex; column-gap: 50px; flex-wrap: wrap; align-items: center; justify-content: center;">
        <form method="POST" action="{{ route('pencil-sketch') }}" enctype="multipart/form-data">
            @csrf
            <label class="picture" for="image" tabIndex="0">
                <span class="picture__image"></span>
            </label>

            <input type="file" name="image" id="image" required>
            <button class="button" type="submit">Convert To Sketch</button>
        </form>
    </div>
    @else
    <h1 style="text-align: center">Your sketch is ready</h1>
        <div style="display: flex; column-gap: 50px; flex-wrap: wrap; align-items: center; justify-content: center;">
           
            @if ($orginal ?? false)
                <label class="picture" for="image" tabIndex="0">
                    <img src="{{ $orginal }}" class="picture__img">
                </label>
            @endif
            @if ($convert ?? false)
                <label class="picture" for="image" tabIndex="0">
                    <img src="{{ $convert }}" class="picture__img">
                </label>
            @endif
        </div>
        <div style="display: flex; column-gap: 50px; flex-wrap: wrap; align-items: center; justify-content: center;">
        <a href="/" class="button">Try another one</a></div>
    @endif
    <script>
        const inputFile = document.querySelector("#image");
        const pictureImage = document.querySelector(".picture__image");
        const pictureImageTxt = "Choose an image";
        pictureImage.innerHTML = pictureImageTxt;

        inputFile.addEventListener("change", function(e) {
            const inputTarget = e.target;
            const file = inputTarget.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function(e) {
                    const readerTarget = e.target;

                    const img = document.createElement("img");
                    img.src = readerTarget.result;
                    img.classList.add("picture__img");

                    pictureImage.innerHTML = "";
                    pictureImage.appendChild(img);
                });

                reader.readAsDataURL(file);
            } else {
                pictureImage.innerHTML = pictureImageTxt;
            }
        });
    </script>
</body>

</html>
