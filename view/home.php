<?php
    
?>
<div class="page">
    <div class="container">
        <div class="panel">
            <h1>logForum</h1>
            <p>A basic forum for fun.</p>
            <p id="formula"></p>
            <script>
                var element = document.getElementById("formula");
                katex.render("c = \\pm\\sqrt{a^2 + b^2}", element, {
                    throwOnError: false
                });
            </script>
        </div>
    </div>
</div>