<?php

?>
                <h1>Interested Page...</h1>
                <div class="parent_info">Parent 1</div>
                <div class="child_info">This text is hidden</div>
                <div class="parent_info">Parent #2</div>
                <div class="child_info">This is the second parent's kid</div>
                
                <script>
                $('.parent_info').next().hide();
                $('.parent_info').click(function() {
                    $(this).next().slideToggle("slow"); 
                });
                </script>
