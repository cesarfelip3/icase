<div class="secondary-masthead">

    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Store</a> <span class="divider">/</span>
            </li>
            <li class="active">Orders</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <div class="alert alert-info">
            <a class="close" data-dismiss="alert" href="#">x</a>
            <h4 class="alert-heading">Information</h4>
            The orders template can be used to list customer orders.
        </div>
        <div class="row">
            <div class="span12">
                <div class="slate">
                    <form class="form-inline">
                        <input type="text" class="input-large" placeholder="Order # or Customer Name...">
                        <select>
                            <option value=""> - From Date - </option>
                        </select>
                        <select>
                            <option value=""> - To Date - </option>
                        </select>
                        <select>
                            <option value=""> - Order Status - </option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <button class="btn btn-primary">Add New Order</button>
            </div>
            <div class="span12">
                <div class="slate">
                    <div class="page-header">
                        <div class="btn-group pull-right">
                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-download-alt"></i> Export
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="">CSV</a></li>
                                <li><a href="">Excel</a></li>
                                <li><a href="">PDF</a></li>
                            </ul>
                        </div>
                        <h2>Orders</h2>
                    </div>
                    <table class="orders-table table">
                        <thead>
                            <tr>
                                <th>Orders</th>
                                <th class="value">Value</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="vieworder.html">#12345 - John Smith</a> <span class="label label-info">New</span><br /><span class="meta">Today at 13:42</span></td>
                                <td class="value">
                                    $132.00
                                </td>
                                <td class="actions">
                                    <a class="btn btn-small btn-primary" href="">View Order</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="span6">
                <div class="pagination pull-left">
                    <ul>
                        <li><a href="#">Prev</a></li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </div>
            </div>
            <div class="span6 listing-buttons pull-right">
                <button class="btn btn-primary">Add New Item</button>
            </div>
        </div>
        <div class="row">
            <div class="span12 footer">
                <p>&copy; Website Name 2012</p>
            </div>
        </div>
    </div>
</div>