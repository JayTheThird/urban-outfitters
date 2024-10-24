 <div class="col-12">
     <div class="card recent-sales overflow-auto">
         <div class="card-body">
             <h5 class="card-title">Delivered Products</h5>

             <table class="table table-borderless datatable">
                 <thead>
                     <tr>
                         <th scope="col">ID</th>
                         <th scope="col">Product Name With Quantity</th>
                         <th scope="col">Price</th>
                         <th scope="col">Date</th>
                         <th scope="col">Status</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $order_query = "SELECT `order_id`, `cart_item`, `total_amount`, `payment_date`, `order_status` FROM `orders` WHERE `order_status` IN ('Delivered')";
                        $order_result = mysqli_query($conn, $order_query);

                        if (mysqli_num_rows($order_result) > 0) {
                            while ($order_row = mysqli_fetch_assoc($order_result)) {
                                $order_id = $order_row['order_id'];
                                $cart_item = json_decode($order_row['cart_item'], true); // Decode JSON
                                $total_amount = $order_row['total_amount'];
                                $payment_date = $order_row['payment_date'];
                                $order_status = $order_row['order_status'];

                                // Build the product display string with truncation logic
                                $product_display = "";
                                $product_count = count($cart_item);

                                foreach ($cart_item as $index => $item) {
                                    if ($index < 2) {  // Display only first 2 products
                                        $product_display .= $item['name'] . "(" . $item['quantity'] . "), ";
                                    }
                                }
                                $product_display = rtrim($product_display, ", "); // Remove trailing comma

                                // Add '...' if more than 2 products exist
                                if ($product_count > 2) {
                                    $product_display .= ", ...";
                                }
                        ?>
                             <form action="" method="get">
                                 <tr>
                                     <th scope="row"><a><?php echo $order_id; ?></a></th>
                                     <td scope="row"><a href="order_details.php?id=<?php echo $order_id; ?>"><?php echo $product_display; ?></a></td>
                                     <td><?php echo "₹" . number_format($total_amount, 2); ?></td>
                                     <td><?php echo $payment_date; ?></td>
                                     <td>
                                         <?php
                                            switch ($order_status) {
                                                case 'Successful':
                                                    echo '<span class="badge bg-success">Active</span>';
                                                    break;
                                                case 'Pending':
                                                    echo '<span class="badge bg-warning">Preparing</span>';
                                                    break;
                                                case 'Shipped':
                                                    echo '<span class="badge bg-info">Shipped</span>';
                                                    break;
                                                case 'Delivered':
                                                    echo '<span class="badge bg-success">Delivered</span>';
                                                    break;
                                                case 'Cancelled':
                                                    echo '<span class="badge bg-danger">Cancelled</span>';
                                                    break;
                                                case 'Preparing':
                                                    echo '<span class="badge bg-warning">Preparing</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">Unknown</span>';
                                                    break;
                                            }
                                            ?>
                                     </td>

                                 </tr>
                             </form>
                         <?php
                            }
                            ?>

                     <?php
                        } else {
                            echo "<tbody><tr><td colspan='5'>No orders found</td></tr></tbody>";
                        }
                        ?>

                 </tbody>


             </table>

         </div>

     </div>
 </div>