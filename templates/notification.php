<?php if(isset($_SESSION['message'])): ?>
    <style>
        #toast {
            visibility: hidden;
            min-width: 250px;
            background-color: black;
            color: white;
            padding: 20px;
            position: fixed;
            right: 30px;
            bottom: 30px;
            text-align: center;
        }

        #toast.show {
            visibility: visible;
        }
    </style>
    <p id="toast" class="message"><?= $_SESSION['message']; ?></p>
    <?= '
        <script>
            function show() {
                console.log(123)
                let t = document.getElementById("toast");
                t.className = "show";
                setTimeout(() => t.className = t.className.replace("show", ""), 2000);
            }
            show();
        </script>
    ' ?>
<?php endif; unset($_SESSION['message']); ?>