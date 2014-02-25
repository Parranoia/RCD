<?php

?>
                <h1>Interested Page...</h1>
                <div class="toggle">Parent 1</div>
                <div>This text is hidden</div>
                <div class="toggle">Parent #2</div>
                <div>This is the second parent's kid</div>
                
                <script>
                $('.toggle').next().hide();
                $('.toggle').click(function() {
                    $(this).next().slideToggle("slow"); 
                });
                </script>
