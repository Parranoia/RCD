<?php

?>
                <h1>Interested Page...</h1>
                <div class="parent_info">
                    <p>Parent 1</p>
                    <p>Radford University</p>
                    <p>4 Children</p>
                    <i class="fa fa-chevron-right"></i>
                </div>
                <div class="child_info">
                    <ul>
                        <li>Child 1</li>
                        <li>Child 2</li>
                        <li>Child 3</li>
                        <li>Child 4</li>
                    </ul>
                </div>
                <div class="parent_info">
                    <p>Parent 2</p>
                    <p>Costco</p>
                    <p>2 Children</p>
                    <i class="fa fa-chevron-right"></i>
                </div>
                <div class="child_info">
                    <ul>
                        <li>Child 1</li>
                        <li>Child 2</li>
                    </ul>
                </div>
                
                <script>
                
                $('.parent_info').click(function() {
                    $(this).next().slideToggle('slow');
                    //$(this).next().width($(this).width()); 
                    $(this).toggleClass('toggled');
                    $(this).children(':nth-child(4)').toggleClass('fa-chevron-right fa-chevron-down');
                });
                </script>
