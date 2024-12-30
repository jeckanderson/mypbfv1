@extends('layout.main')

@section('main')
    <div class="content">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 2xl:col-span-9">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: General Report -->
                    <div class="col-span-12 mt-8">
                        <div class="flex items-center h-10 intro-y">
                            <h2 class="mr-5 text-lg font-medium truncate">
                                General Report
                            </h2>
                            <a href="" class="flex items-center ml-auto text-primary"> <i data-feather="refresh-ccw"
                                    class="w-4 h-4 mr-3"></i> Reload Data </a>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="p-5 box">
                                        <div class="flex">
                                            <i data-feather="shopping-cart" class="report-box__icon text-primary"></i>
                                            <div class="ml-auto">
                                                <div class="cursor-pointer report-box__indicator bg-success tooltip"
                                                    title="33% Higher than last month"> 33% <i data-feather="chevron-up"
                                                        class="w-4 h-4 ml-0.5"></i> </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-3xl font-medium leading-8">4.710</div>
                                        <div class="mt-1 text-base text-slate-500">Item Sales</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="p-5 box">
                                        <div class="flex">
                                            <i data-feather="credit-card" class="report-box__icon text-pending"></i>
                                            <div class="ml-auto">
                                                <div class="cursor-pointer report-box__indicator bg-danger tooltip"
                                                    title="2% Lower than last month"> 2% <i data-feather="chevron-down"
                                                        class="w-4 h-4 ml-0.5"></i> </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-3xl font-medium leading-8">3.721</div>
                                        <div class="mt-1 text-base text-slate-500">New Orders</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="p-5 box">
                                        <div class="flex">
                                            <i data-feather="monitor" class="report-box__icon text-warning"></i>
                                            <div class="ml-auto">
                                                <div class="cursor-pointer report-box__indicator bg-success tooltip"
                                                    title="12% Higher than last month"> 12% <i data-feather="chevron-up"
                                                        class="w-4 h-4 ml-0.5"></i> </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-3xl font-medium leading-8">2.149</div>
                                        <div class="mt-1 text-base text-slate-500">Total Products</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="p-5 box">
                                        <div class="flex">
                                            <i data-feather="user" class="report-box__icon text-success"></i>
                                            <div class="ml-auto">
                                                <div class="cursor-pointer report-box__indicator bg-success tooltip"
                                                    title="22% Higher than last month"> 22% <i data-feather="chevron-up"
                                                        class="w-4 h-4 ml-0.5"></i> </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-3xl font-medium leading-8">152.040</div>
                                        <div class="mt-1 text-base text-slate-500">Unique Visitor</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: General Report -->
                    <!-- BEGIN: Sales Report -->
                    <div class="col-span-12 mt-8 lg:col-span-6">
                        <div class="items-center block h-10 intro-y sm:flex">
                            <h2 class="mr-5 text-lg font-medium truncate">
                                Sales Report
                            </h2>
                            <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                <i data-feather="calendar" class="absolute inset-y-0 left-0 z-10 w-4 h-4 my-auto ml-3"></i>
                                <input type="text" class="pl-10 datepicker form-control sm:w-56 box">
                            </div>
                        </div>
                        <div class="p-5 mt-12 intro-y box sm:mt-5">
                            <div class="flex flex-col xl:flex-row xl:items-center">
                                <div class="flex">
                                    <div>
                                        <div class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl">
                                            $15,000</div>
                                        <div class="mt-0.5 text-slate-500">This Month</div>
                                    </div>
                                    <div
                                        class="w-px h-12 mx-4 border border-r border-dashed border-slate-200 dark:border-darkmode-300 xl:mx-5">
                                    </div>
                                    <div>
                                        <div class="text-lg font-medium text-slate-500 xl:text-xl">$10,000</div>
                                        <div class="mt-0.5 text-slate-500">Last Month</div>
                                    </div>
                                </div>
                                <div class="mt-5 dropdown xl:ml-auto xl:mt-0">
                                    <button class="font-normal dropdown-toggle btn btn-outline-secondary"
                                        aria-expanded="false" data-tw-toggle="dropdown"> Filter by Category <i
                                            data-feather="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                                    <div class="w-40 dropdown-menu">
                                        <ul class="h-32 overflow-y-auto dropdown-content">
                                            <li><a href="" class="dropdown-item">PC & Laptop</a></li>
                                            <li><a href="" class="dropdown-item">Smartphone</a></li>
                                            <li><a href="" class="dropdown-item">Electronic</a></li>
                                            <li><a href="" class="dropdown-item">Photography</a></li>
                                            <li><a href="" class="dropdown-item">Sport</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="report-chart">
                                <canvas id="report-line-chart" height="169" class="mt-6"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- END: Sales Report -->
                    <!-- BEGIN: Weekly Top Seller -->
                    <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-3">
                        <div class="flex items-center h-10 intro-y">
                            <h2 class="mr-5 text-lg font-medium truncate">
                                Weekly Top Seller
                            </h2>
                            <a href="" class="ml-auto truncate text-primary">Show More</a>
                        </div>
                        <div class="p-5 mt-5 intro-y box">
                            <canvas class="mt-3" id="report-pie-chart" height="300"></canvas>
                            <div class="mt-8">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-primary"></div>
                                    <span class="truncate">17 - 30 Years old</span> <span
                                        class="font-medium xl:ml-auto">62%</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-pending"></div>
                                    <span class="truncate">31 - 50 Years old</span> <span
                                        class="font-medium xl:ml-auto">33%</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-warning"></div>
                                    <span class="truncate">>= 50 Years old</span> <span
                                        class="font-medium xl:ml-auto">10%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Weekly Top Seller -->
                    <!-- BEGIN: Sales Report -->
                    <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-3">
                        <div class="flex items-center h-10 intro-y">
                            <h2 class="mr-5 text-lg font-medium truncate">
                                Sales Report
                            </h2>
                            <a href="" class="ml-auto truncate text-primary">Show More</a>
                        </div>
                        <div class="p-5 mt-5 intro-y box">
                            <canvas class="mt-3" id="report-donut-chart" height="300"></canvas>
                            <div class="mt-8">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-primary"></div>
                                    <span class="truncate">17 - 30 Years old</span> <span
                                        class="font-medium xl:ml-auto">62%</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-pending"></div>
                                    <span class="truncate">31 - 50 Years old</span> <span
                                        class="font-medium xl:ml-auto">33%</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <div class="w-2 h-2 mr-3 rounded-full bg-warning"></div>
                                    <span class="truncate">>= 50 Years old</span> <span
                                        class="font-medium xl:ml-auto">10%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Sales Report -->
                    <!-- BEGIN: Official Store -->
                    <div class="col-span-12 mt-6 xl:col-span-8">
                        <div class="items-center block h-10 intro-y sm:flex">
                            <h2 class="mr-5 text-lg font-medium truncate">
                                Official Store
                            </h2>
                            <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                <i data-feather="map-pin" class="absolute inset-y-0 left-0 z-10 w-4 h-4 my-auto ml-3"></i>
                                <input type="text" class="pl-10 form-control sm:w-40 box"
                                    placeholder="Filter by city">
                            </div>
                        </div>
                        <div class="p-5 mt-12 intro-y box sm:mt-5">
                            <div>250 Official stores in 21 countries, click the marker to see location details.</div>
                            <div class="mt-5 rounded-md report-maps bg-slate-200" data-center="-6.2425342, 106.8626478"
                                data-sources="/dist/json/location.json"></div>
                        </div>
                    </div>
                    <!-- END: Official Store -->
                    <!-- BEGIN: Weekly Best Sellers -->
                    <div class="col-span-12 mt-6 xl:col-span-4">
                        <div class="flex items-center h-10 intro-y">
                            <h2 class="mr-5 text-lg font-medium truncate">
                                Weekly Best Sellers
                            </h2>
                        </div>
                        <div class="mt-5">
                            <div class="intro-y">
                                <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" src="dist/images/profile-15.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Al Pacino</div>
                                        <div class="text-slate-500 text-xs mt-0.5">16 September 2020</div>
                                    </div>
                                    <div
                                        class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success">
                                        137 Sales</div>
                                </div>
                            </div>
                            <div class="intro-y">
                                <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" src="dist/images/profile-8.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Russell Crowe</div>
                                        <div class="text-slate-500 text-xs mt-0.5">21 November 2022</div>
                                    </div>
                                    <div
                                        class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success">
                                        137 Sales</div>
                                </div>
                            </div>
                            <div class="intro-y">
                                <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" src="dist/images/profile-2.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Brad Pitt</div>
                                        <div class="text-slate-500 text-xs mt-0.5">13 October 2022</div>
                                    </div>
                                    <div
                                        class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success">
                                        137 Sales</div>
                                </div>
                            </div>
                            <div class="intro-y">
                                <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" src="dist/images/profile-7.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">Denzel Washington</div>
                                        <div class="text-slate-500 text-xs mt-0.5">2 August 2021</div>
                                    </div>
                                    <div
                                        class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success">
                                        137 Sales</div>
                                </div>
                            </div>
                            <a href=""
                                class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-slate-400 dark:border-darkmode-300 text-slate-500">View
                                More</a>
                        </div>
                    </div>
                    <!-- END: Weekly Best Sellers -->
                    <!-- BEGIN: General Report -->
                    <div class="grid grid-cols-12 col-span-12 gap-6 mt-8">
                        <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                            <div class="p-5 box zoom-in">
                                <div class="flex items-center">
                                    <div class="flex-none w-2/4">
                                        <div class="text-lg font-medium truncate">Target Sales</div>
                                        <div class="mt-1 text-slate-500">300 Sales</div>
                                    </div>
                                    <div class="relative flex-none ml-auto">
                                        <canvas id="report-donut-chart-1" width="90" height="90"></canvas>
                                        <div
                                            class="absolute top-0 left-0 flex items-center justify-center w-full h-full font-medium">
                                            20%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                            <div class="p-5 box zoom-in">
                                <div class="flex">
                                    <div class="mr-3 text-lg font-medium truncate">Social Media</div>
                                    <div
                                        class="flex items-center px-2 py-1 ml-auto text-xs truncate rounded-full cursor-pointer bg-slate-100 dark:bg-darkmode-400 text-slate-500">
                                        320 Followers</div>
                                </div>
                                <div class="mt-4">
                                    <canvas class="-ml-1 simple-line-chart-1" height="60"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                            <div class="p-5 box zoom-in">
                                <div class="flex items-center">
                                    <div class="flex-none w-2/4">
                                        <div class="text-lg font-medium truncate">New Products</div>
                                        <div class="mt-1 text-slate-500">1450 Products</div>
                                    </div>
                                    <div class="relative flex-none ml-auto">
                                        <canvas id="report-donut-chart-2" width="90" height="90"></canvas>
                                        <div
                                            class="absolute top-0 left-0 flex items-center justify-center w-full h-full font-medium">
                                            45%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 2xl:col-span-3 intro-y">
                            <div class="p-5 box zoom-in">
                                <div class="flex">
                                    <div class="mr-3 text-lg font-medium truncate">Posted Ads</div>
                                    <div
                                        class="flex items-center px-2 py-1 ml-auto text-xs truncate rounded-full cursor-pointer bg-slate-100 dark:bg-darkmode-400 text-slate-500">
                                        180 Campaign</div>
                                </div>
                                <div class="mt-4">
                                    <canvas class="-ml-1 simple-line-chart-1" height="60"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: General Report -->
                    <!-- BEGIN: Weekly Top Products -->
                    <div class="col-span-12 mt-6">
                        <div class="items-center block h-10 intro-y sm:flex">
                            <h2 class="mr-5 text-lg font-medium truncate">
                                Weekly Top Products
                            </h2>
                            <div class="flex items-center mt-3 sm:ml-auto sm:mt-0">
                                <button class="flex items-center btn box text-slate-600 dark:text-slate-300"> <i
                                        data-feather="file-text" class="hidden w-4 h-4 mr-2 sm:block"></i> Export to
                                    Excel </button>
                                <button class="flex items-center ml-3 btn box text-slate-600 dark:text-slate-300"> <i
                                        data-feather="file-text" class="hidden w-4 h-4 mr-2 sm:block"></i> Export to PDF
                                </button>
                            </div>
                        </div>
                        <div class="mt-8 overflow-auto intro-y lg:overflow-visible sm:mt-0">
                            <table class="table table-report sm:mt-2">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">IMAGES</th>
                                        <th class="whitespace-nowrap">PRODUCT NAME</th>
                                        <th class="text-center whitespace-nowrap">STOCK</th>
                                        <th class="text-center whitespace-nowrap">STATUS</th>
                                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="intro-x">
                                        <td class="w-40">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-13.jpg"
                                                        title="Uploaded at 16 September 2020">
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-15.jpg"
                                                        title="Uploaded at 23 November 2020">
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-4.jpg"
                                                        title="Uploaded at 11 September 2021">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="font-medium whitespace-nowrap">Nikon Z6</a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Photography</div>
                                        </td>
                                        <td class="text-center">79</td>
                                        <td class="w-40">
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                        </td>
                                        <td class="w-56 table-report__action">
                                            <div class="flex items-center justify-center">
                                                <a class="flex items-center mr-3" href=""> <i
                                                        data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                                <a class="flex items-center text-danger" href=""> <i
                                                        data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="intro-x">
                                        <td class="w-40">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-4.jpg"
                                                        title="Uploaded at 21 November 2022">
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-4.jpg"
                                                        title="Uploaded at 27 December 2020">
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-10.jpg"
                                                        title="Uploaded at 12 December 2021">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="font-medium whitespace-nowrap">Nike Tanjun</a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Sport &amp;
                                                Outdoor</div>
                                        </td>
                                        <td class="text-center">50</td>
                                        <td class="w-40">
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                        </td>
                                        <td class="w-56 table-report__action">
                                            <div class="flex items-center justify-center">
                                                <a class="flex items-center mr-3" href=""> <i
                                                        data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                                <a class="flex items-center text-danger" href=""> <i
                                                        data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="intro-x">
                                        <td class="w-40">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-5.jpg"
                                                        title="Uploaded at 13 October 2022">
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-1.jpg"
                                                        title="Uploaded at 5 August 2022">
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-15.jpg"
                                                        title="Uploaded at 21 May 2022">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="font-medium whitespace-nowrap">Nike Tanjun</a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Sport &amp;
                                                Outdoor</div>
                                        </td>
                                        <td class="text-center">106</td>
                                        <td class="w-40">
                                            <div class="flex items-center justify-center text-danger"> <i
                                                    data-feather="check-square" class="w-4 h-4 mr-2"></i> Inactive
                                            </div>
                                        </td>
                                        <td class="w-56 table-report__action">
                                            <div class="flex items-center justify-center">
                                                <a class="flex items-center mr-3" href=""> <i
                                                        data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                                <a class="flex items-center text-danger" href=""> <i
                                                        data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="intro-x">
                                        <td class="w-40">
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-4.jpg"
                                                        title="Uploaded at 2 August 2021">
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-3.jpg"
                                                        title="Uploaded at 24 November 2022">
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="rounded-full tooltip" src="dist/images/preview-4.jpg"
                                                        title="Uploaded at 19 October 2022">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="" class="font-medium whitespace-nowrap">Sony A7 III</a>
                                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Photography</div>
                                        </td>
                                        <td class="text-center">50</td>
                                        <td class="w-40">
                                            <div class="flex items-center justify-center text-success"> <i
                                                    data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                        </td>
                                        <td class="w-56 table-report__action">
                                            <div class="flex items-center justify-center">
                                                <a class="flex items-center mr-3" href=""> <i
                                                        data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                                <a class="flex items-center text-danger" href=""> <i
                                                        data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex flex-wrap items-center mt-3 intro-y sm:flex-row sm:flex-nowrap">
                            <nav class="w-full sm:w-auto sm:mr-auto">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4"
                                                data-feather="chevrons-left"></i> </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4"
                                                data-feather="chevron-left"></i> </a>
                                    </li>
                                    <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">1</a> </li>
                                    <li class="page-item active"> <a class="page-link" href="#">2</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">3</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4"
                                                data-feather="chevron-right"></i> </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4"
                                                data-feather="chevrons-right"></i> </a>
                                    </li>
                                </ul>
                            </nav>
                            <select class="w-20 mt-3 form-select box sm:mt-0">
                                <option>10</option>
                                <option>25</option>
                                <option>35</option>
                                <option>50</option>
                            </select>
                        </div>
                    </div>
                    <!-- END: Weekly Top Products -->
                </div>
            </div>
            <div class="col-span-12 2xl:col-span-3">
                <div class="pb-10 -mb-10 2xl:border-l">
                    <div class="grid grid-cols-12 gap-6 2xl:pl-6">
                        <!-- BEGIN: Transactions -->
                        <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 2xl:col-span-12 2xl:mt-8">
                            <div class="flex items-center h-10 intro-x">
                                <h2 class="mr-5 text-lg font-medium truncate">
                                    Transactions
                                </h2>
                            </div>
                            <div class="mt-5">
                                <div class="intro-x">
                                    <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-15.jpg">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium">Al Pacino</div>
                                            <div class="text-slate-500 text-xs mt-0.5">16 September 2020</div>
                                        </div>
                                        <div class="text-success">+$47</div>
                                    </div>
                                </div>
                                <div class="intro-x">
                                    <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-8.jpg">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium">Russell Crowe</div>
                                            <div class="text-slate-500 text-xs mt-0.5">21 November 2022</div>
                                        </div>
                                        <div class="text-success">+$55</div>
                                    </div>
                                </div>
                                <div class="intro-x">
                                    <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-2.jpg">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium">Brad Pitt</div>
                                            <div class="text-slate-500 text-xs mt-0.5">13 October 2022</div>
                                        </div>
                                        <div class="text-danger">-$212</div>
                                    </div>
                                </div>
                                <div class="intro-x">
                                    <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-7.jpg">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium">Denzel Washington</div>
                                            <div class="text-slate-500 text-xs mt-0.5">2 August 2021</div>
                                        </div>
                                        <div class="text-success">+$26</div>
                                    </div>
                                </div>
                                <div class="intro-x">
                                    <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-5.jpg">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium">Kevin Spacey</div>
                                            <div class="text-slate-500 text-xs mt-0.5">21 May 2022</div>
                                        </div>
                                        <div class="text-success">+$23</div>
                                    </div>
                                </div>
                                <a href=""
                                    class="block w-full py-3 text-center border border-dotted rounded-md intro-x border-slate-400 dark:border-darkmode-300 text-slate-500">View
                                    More</a>
                            </div>
                        </div>
                        <!-- END: Transactions -->
                        <!-- BEGIN: Recent Activities -->
                        <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 2xl:col-span-12">
                            <div class="flex items-center h-10 intro-x">
                                <h2 class="mr-5 text-lg font-medium truncate">
                                    Recent Activities
                                </h2>
                                <a href="" class="ml-auto truncate text-primary">Show More</a>
                            </div>
                            <div
                                class="mt-5 relative before:block before:absolute before:w-px before:h-[85%] before:bg-slate-200 before:dark:bg-darkmode-400 before:ml-5 before:mt-5">
                                <div class="relative flex items-center mb-3 intro-x">
                                    <div
                                        class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-3.jpg">
                                        </div>
                                    </div>
                                    <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                        <div class="flex items-center">
                                            <div class="font-medium">Johnny Depp</div>
                                            <div class="ml-auto text-xs text-slate-500">07:00 PM</div>
                                        </div>
                                        <div class="mt-1 text-slate-500">Has joined the team</div>
                                    </div>
                                </div>
                                <div class="relative flex items-center mb-3 intro-x">
                                    <div
                                        class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-15.jpg">
                                        </div>
                                    </div>
                                    <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                        <div class="flex items-center">
                                            <div class="font-medium">Christian Bale</div>
                                            <div class="ml-auto text-xs text-slate-500">07:00 PM</div>
                                        </div>
                                        <div class="text-slate-500">
                                            <div class="mt-1">Added 3 new photos</div>
                                            <div class="flex mt-2">
                                                <div class="w-8 h-8 mr-1 tooltip image-fit zoom-in" title="Nikon Z6">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="border border-white rounded-md"
                                                        src="dist/images/preview-13.jpg">
                                                </div>
                                                <div class="w-8 h-8 mr-1 tooltip image-fit zoom-in" title="Nike Tanjun">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="border border-white rounded-md"
                                                        src="dist/images/preview-5.jpg">
                                                </div>
                                                <div class="w-8 h-8 mr-1 tooltip image-fit zoom-in" title="Nike Tanjun">
                                                    <img alt="Rubick Tailwind HTML Admin Template"
                                                        class="border border-white rounded-md"
                                                        src="dist/images/preview-10.jpg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4 text-xs text-center intro-x text-slate-500">12 November</div>
                                <div class="relative flex items-center mb-3 intro-x">
                                    <div
                                        class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-12.jpg">
                                        </div>
                                    </div>
                                    <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                        <div class="flex items-center">
                                            <div class="font-medium">Brad Pitt</div>
                                            <div class="ml-auto text-xs text-slate-500">07:00 PM</div>
                                        </div>
                                        <div class="mt-1 text-slate-500">Has changed <a class="text-primary"
                                                href="">Nike Air Max 270</a> price and description</div>
                                    </div>
                                </div>
                                <div class="relative flex items-center mb-3 intro-x">
                                    <div
                                        class="before:block before:absolute before:w-20 before:h-px before:bg-slate-200 before:dark:bg-darkmode-400 before:mt-5 before:ml-5">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img alt="Rubick Tailwind HTML Admin Template"
                                                src="dist/images/profile-4.jpg">
                                        </div>
                                    </div>
                                    <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                        <div class="flex items-center">
                                            <div class="font-medium">John Travolta</div>
                                            <div class="ml-auto text-xs text-slate-500">07:00 PM</div>
                                        </div>
                                        <div class="mt-1 text-slate-500">Has changed <a class="text-primary"
                                                href="">Sony Master Series A9G</a> description</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Recent Activities -->
                        <!-- BEGIN: Important Notes -->
                        <div
                            class="col-span-12 mt-3 md:col-span-6 xl:col-span-12 xl:col-start-1 xl:row-start-1 2xl:col-start-auto 2xl:row-start-auto">
                            <div class="flex items-center h-10 intro-x">
                                <h2 class="mr-auto text-lg font-medium truncate">
                                    Important Notes
                                </h2>
                                <button data-carousel="important-notes" data-target="prev"
                                    class="px-2 mr-2 tiny-slider-navigator btn border-slate-300 text-slate-600 dark:text-slate-300">
                                    <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                                <button data-carousel="important-notes" data-target="next"
                                    class="px-2 mr-2 tiny-slider-navigator btn border-slate-300 text-slate-600 dark:text-slate-300">
                                    <i data-feather="chevron-right" class="w-4 h-4"></i> </button>
                            </div>
                            <div class="mt-5 intro-x">
                                <div class="box zoom-in">
                                    <div class="tiny-slider" id="important-notes">
                                        <div class="p-5">
                                            <div class="text-base font-medium truncate">Lorem Ipsum is simply dummy text
                                            </div>
                                            <div class="mt-1 text-slate-400">20 Hours ago</div>
                                            <div class="mt-1 text-justify text-slate-500">Lorem Ipsum is simply dummy text
                                                of the printing and typesetting industry. Lorem Ipsum has been the
                                                industry's standard dummy text ever since the 1500s.</div>
                                            <div class="flex mt-5 font-medium">
                                                <button type="button" class="px-2 py-1 btn btn-secondary">View
                                                    Notes</button>
                                                <button type="button"
                                                    class="px-2 py-1 ml-auto btn btn-outline-secondary">Dismiss</button>
                                            </div>
                                        </div>
                                        <div class="p-5">
                                            <div class="text-base font-medium truncate">Lorem Ipsum is simply dummy text
                                            </div>
                                            <div class="mt-1 text-slate-400">20 Hours ago</div>
                                            <div class="mt-1 text-justify text-slate-500">Lorem Ipsum is simply dummy text
                                                of the printing and typesetting industry. Lorem Ipsum has been the
                                                industry's standard dummy text ever since the 1500s.</div>
                                            <div class="flex mt-5 font-medium">
                                                <button type="button" class="px-2 py-1 btn btn-secondary">View
                                                    Notes</button>
                                                <button type="button"
                                                    class="px-2 py-1 ml-auto btn btn-outline-secondary">Dismiss</button>
                                            </div>
                                        </div>
                                        <div class="p-5">
                                            <div class="text-base font-medium truncate">Lorem Ipsum is simply dummy text
                                            </div>
                                            <div class="mt-1 text-slate-400">20 Hours ago</div>
                                            <div class="mt-1 text-justify text-slate-500">Lorem Ipsum is simply dummy text
                                                of the printing and typesetting industry. Lorem Ipsum has been the
                                                industry's standard dummy text ever since the 1500s.</div>
                                            <div class="flex mt-5 font-medium">
                                                <button type="button" class="px-2 py-1 btn btn-secondary">View
                                                    Notes</button>
                                                <button type="button"
                                                    class="px-2 py-1 ml-auto btn btn-outline-secondary">Dismiss</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Important Notes -->
                        <!-- BEGIN: Schedules -->
                        <div
                            class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 2xl:col-span-12 xl:col-start-1 xl:row-start-2 2xl:col-start-auto 2xl:row-start-auto">
                            <div class="flex items-center h-10 intro-x">
                                <h2 class="mr-5 text-lg font-medium truncate">
                                    Schedules
                                </h2>
                                <a href="" class="flex items-center ml-auto truncate text-primary"> <i
                                        data-feather="plus" class="w-4 h-4 mr-1"></i> Add New Schedules </a>
                            </div>
                            <div class="mt-5">
                                <div class="intro-x box">
                                    <div class="p-5">
                                        <div class="flex">
                                            <i data-feather="chevron-left" class="w-5 h-5 text-slate-500"></i>
                                            <div class="mx-auto text-base font-medium">April</div>
                                            <i data-feather="chevron-right" class="w-5 h-5 text-slate-500"></i>
                                        </div>
                                        <div class="grid grid-cols-7 gap-4 mt-5 text-center">
                                            <div class="font-medium">Su</div>
                                            <div class="font-medium">Mo</div>
                                            <div class="font-medium">Tu</div>
                                            <div class="font-medium">We</div>
                                            <div class="font-medium">Th</div>
                                            <div class="font-medium">Fr</div>
                                            <div class="font-medium">Sa</div>
                                            <div class="py-0.5 rounded relative text-slate-500">29</div>
                                            <div class="py-0.5 rounded relative text-slate-500">30</div>
                                            <div class="py-0.5 rounded relative text-slate-500">31</div>
                                            <div class="py-0.5 rounded relative">1</div>
                                            <div class="py-0.5 rounded relative">2</div>
                                            <div class="py-0.5 rounded relative">3</div>
                                            <div class="py-0.5 rounded relative">4</div>
                                            <div class="py-0.5 rounded relative">5</div>
                                            <div class="py-0.5 bg-success/20 dark:bg-success/30 rounded relative">6</div>
                                            <div class="py-0.5 rounded relative">7</div>
                                            <div class="py-0.5 bg-primary text-white rounded relative">8</div>
                                            <div class="py-0.5 rounded relative">9</div>
                                            <div class="py-0.5 rounded relative">10</div>
                                            <div class="py-0.5 rounded relative">11</div>
                                            <div class="py-0.5 rounded relative">12</div>
                                            <div class="py-0.5 rounded relative">13</div>
                                            <div class="py-0.5 rounded relative">14</div>
                                            <div class="py-0.5 rounded relative">15</div>
                                            <div class="py-0.5 rounded relative">16</div>
                                            <div class="py-0.5 rounded relative">17</div>
                                            <div class="py-0.5 rounded relative">18</div>
                                            <div class="py-0.5 rounded relative">19</div>
                                            <div class="py-0.5 rounded relative">20</div>
                                            <div class="py-0.5 rounded relative">21</div>
                                            <div class="py-0.5 rounded relative">22</div>
                                            <div class="py-0.5 bg-pending/20 dark:bg-pending/30 rounded relative">23</div>
                                            <div class="py-0.5 rounded relative">24</div>
                                            <div class="py-0.5 rounded relative">25</div>
                                            <div class="py-0.5 rounded relative">26</div>
                                            <div class="py-0.5 bg-primary/10 dark:bg-primary/50 rounded relative">27</div>
                                            <div class="py-0.5 rounded relative">28</div>
                                            <div class="py-0.5 rounded relative">29</div>
                                            <div class="py-0.5 rounded relative">30</div>
                                            <div class="py-0.5 rounded relative text-slate-500">1</div>
                                            <div class="py-0.5 rounded relative text-slate-500">2</div>
                                            <div class="py-0.5 rounded relative text-slate-500">3</div>
                                            <div class="py-0.5 rounded relative text-slate-500">4</div>
                                            <div class="py-0.5 rounded relative text-slate-500">5</div>
                                            <div class="py-0.5 rounded relative text-slate-500">6</div>
                                            <div class="py-0.5 rounded relative text-slate-500">7</div>
                                            <div class="py-0.5 rounded relative text-slate-500">8</div>
                                            <div class="py-0.5 rounded relative text-slate-500">9</div>
                                        </div>
                                    </div>
                                    <div class="p-5 border-t border-slate-200/60">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 mr-3 rounded-full bg-pending"></div>
                                            <span class="truncate">UI/UX Workshop</span> <span
                                                class="font-medium xl:ml-auto">23th</span>
                                        </div>
                                        <div class="flex items-center mt-4">
                                            <div class="w-2 h-2 mr-3 rounded-full bg-primary"></div>
                                            <span class="truncate">VueJs Frontend Development</span> <span
                                                class="font-medium xl:ml-auto">10th</span>
                                        </div>
                                        <div class="flex items-center mt-4">
                                            <div class="w-2 h-2 mr-3 rounded-full bg-warning"></div>
                                            <span class="truncate">Laravel Rest API</span> <span
                                                class="font-medium xl:ml-auto">31th</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Schedules -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
