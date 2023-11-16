<x-admin::layouts>
    <x-slot:title>
        @lang('bagisto_graphql::app.admin.notification.title')
    </x-slot:title>
            <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
                <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                    <h1>{{ __('bagisto_graphql::app.admin.notification.title') }}</h1>
                </p>
                
                <div class="page-action">
                    <a href="{{ route('admin.push_notification.create') }}" class="btn btn-lg btn-primary">
                        {{ __('bagisto_graphql::app.admin.notification.add-title') }}
                    </a>
                </div>
            </div>
        </div> 
    <x-admin::datagrid src="{{ route('admin.push_notification.index') }}">
        {{-- @dd("sdfgfsg"); --}}

        <template #header="{ columns, records, sortPage, selectAllRecords, applied, isLoading}">
            <template v-if="! isLoading">
               <div class="row grid grid-cols-[0.5fr_0.5fr_1fr] grid-rows-1 items-center px-[16px] py-[10px] border-b-[1px] dark:border-gray-800">
                   <div
                       class="flex gap-[10px] items-center select-none"
                       v-for="(columnGroup, index) in [['increment_id', 'created_at', 'status'], ['base_grand_total', 'method', 'channel_name'], ['full_name', 'customer_email', 'location', 'image']]"
                   >
                       <p class="text-gray-600 dark:text-gray-300">
                           <span class="[&>*]:after:content-['_/_']">
                               <template v-for="column in columnGroup">
                                   <span
                                       class="after:content-['/'] last:after:content-['']"
                                       :class="{
                                           'text-gray-800 dark:text-white font-medium': applied.sort.column == column,
                                           'cursor-pointer hover:text-gray-800 dark:hover:text-white': columns.find(columnTemp => columnTemp.index === column)?.sortable,
                                       }"
                                       @click="
                                           columns.find(columnTemp => columnTemp.index === column)?.sortable ? sortPage(columns.find(columnTemp => columnTemp.index === column)): {}
                                       "
                                   >
                                       @{{ columns.find(columnTemp => columnTemp.index === column)?.label }}
                                   </span>
                               </template>
                           </span>

                           {{-- <i
                               class="ltr:ml-[5px] rtl:mr-[5px] text-[16px] text-gray-800 dark:text-white align-text-bottom"
                               :class="[applied.sort.order === 'asc' ? 'icon-down-stat': 'icon-up-stat']"
                               v-if="columnGroup.includes(applied.sort.column)"
                           ></i> --}}
                       </p>
                   </div>
               </div>
           </template>

           {{-- Datagrid Head Shimmer --}}
           {{-- <template v-else>
               <x-admin::shimmer.datagrid.table.head :isMultiRow="true"></x-admin::shimmer.datagrid.table.head>
           </template> --}}
       {{-- </template> --}}
{{-- 
       <template #body="{ columns, records, setCurrentSelectionMode, applied, isLoading }">
           <template v-if="! isLoading">
               <div
                   class="row grid grid-cols-4 px-[16px] py-[10px] border-b-[1px] dark:border-gray-800 transition-all hover:bg-gray-50 dark:hover:bg-gray-950"
                   v-for="record in records"
               > --}}
                   {{-- Order Id, Created, Status Section --}}
                   {{-- <div class="">
                       <div class="flex gap-[10px]">
                           <div class="flex flex-col gap-[6px]">
                               <p
                                   class="text-[16px] text-gray-800 dark:text-white font-semibold"
                               >
                                   @{{ "@lang('admin::app.sales.orders.index.datagrid.id')".replace(':id', record.increment_id) }}
                               </p>

                               <p
                                   class="text-gray-600 dark:text-gray-300"
                                   v-text="record.created_at"
                               >
                               </p>

                               <p
                                   v-if="record.is_closure"
                                   v-html="record.status"
                               >
                               </p>

                               <p
                                   v-else
                                   v-text="record.status"
                               >
                               </p>
                           </div>
                       </div>
                   </div> --}}

                   {{-- Total Amount, Pay Via, Channel --}}
                   {{-- <div class="">
                       <div class="flex flex-col gap-[6px]">
                           <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                               @{{ $admin.formatPrice(record.base_grand_total) }}
                           </p>

                           <p class="text-gray-600 dark:text-gray-300">
                               @lang('admin::app.sales.orders.index.datagrid.pay-by', ['method' => ''])@{{ record.method }}
                           </p>

                           <p
                               class="text-gray-600 dark:text-gray-300"
                               v-text="record.channel_name"
                           >
                           </p>
                       </div>
                   </div> --}}

                   {{-- Custoemr, Email, Location Section --}}
                   {{-- <div class="">
                       <div class="flex flex-col gap-[6px]">
                           <p
                               class="text-[16px] text-gray-800 dark:text-white"
                               v-text="record.full_name"
                           >
                           </p>

                           <p
                               class="text-gray-600 dark:text-gray-300"
                               v-text="record.customer_email"
                           >
                           </p>

                           <p
                               class="text-gray-600 dark:text-gray-300"
                               v-text="record.location"
                           >
                           </p>
                       </div>
                   </div> --}}

                   {{-- Imgaes Section --}}
                   {{-- <div class="flex gap-x-[16px] justify-between items-center">
                       <div class="flex flex-col gap-[6px]">
                           <p
                               v-if="record.is_closure"
                               class="text-gray-600 dark:text-gray-300"
                               v-html="record.image"
                           >
                           </p>

                           <p
                               v-else
                               class="text-gray-600 dark:text-gray-300"
                               v-html="record.image"
                           >
                           </p>

                       </div>

                       <a :href=`{{ route('admin.sales.orders.view', '') }}/${record.id}`>
                           <span class="icon-sort-right text-[24px] ltr:ml-[4px] rtl:mr-[4px] p-[6px] cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"></span>
                       </a>
                   </div>
               </div>
           </template> --}}

           {{-- Datagrid Body Shimmer --}}
           {{-- <template v-else>
               <x-admin::shimmer.datagrid.table.body :isMultiRow="true"></x-admin::shimmer.datagrid.table.body>
           </template> --}}
       </template>

      
    </x-admin::datagrid>
</x-admin::layouts>
{{-- 
@push('scripts')
    <script>
        function reloadPage(getVar, getVal) {
            let url = new URL(window.location.href);
            url.searchParams.set(getVar, getVal);

            window.location.href = url.href;
        }
        
    </script>
@endpush --}}
