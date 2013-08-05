<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $base; ?>">Admin</a> <span class="divider">/</span>
            </li>
            <li class="active">Sales Report</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <div class="alert alert-info">
            <a class="close" data-dismiss="alert" href="#">x</a>
            <h4 class="alert-heading">Information</h4>
            The report template can be used to display charts and report data, such as sales reports, website stats and member sign ups.
        </div>
        <div class="row">
            <div class="span12">
                <div class="slate">
                    <form class="form-inline">
                        <input type="text" class="input-large" placeholder="Keyword...">
                        <select>
                            <option value=""> - From Date - </option>
                        </select>
                        <select>
                            <option value=""> - To Date - </option>
                        </select>
                        <select>
                            <option value=""> - Filter - </option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filter Report</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="slate">
                    <div class="page-header">
                        <h2><i class="icon-signal pull-right"></i>Sales Report</h2>
                    </div>
                    <div id="placeholder" style="height: 400px;"></div>
                </div>
            </div>
        </div>
        <div class="row">
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
                        <h2>Report Data</h2>
                    </div>
                    <table class="orders-table table">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th class="value">Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Today</td>
                                <td class="value">$124.00</td>
                            </tr>
                            <tr>
                                <td>Yesterday</td>
                                <td class="value">$124.00</td>
                            </tr>
                            <tr>
                                <td>5th June 2012</td>
                                <td class="value">$124.00</td>
                            </tr>
                            <tr>
                                <td>4th June 2012</td>
                                <td class="value">$124.00</td>
                            </tr>
                            <tr>
                                <td>3rd June 2012</td>
                                <td class="value">$124.00</td>
                            </tr>
                            <tr>
                                <td>2nd June 2012</td>
                                <td class="value">$124.00</td>
                            </tr>
                            <tr>
                                <td>1st June 2012</td>
                                <td class="value">$124.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 footer">
                <p>&copy; Website Name 2012</p>
            </div>
        </div>
    </div>
</div>