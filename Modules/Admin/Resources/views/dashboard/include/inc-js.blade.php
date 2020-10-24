<script type="text/javascript"
        src="{{ asset('static/backend/js/admin/dashboard/order.js?v='.time()) }}">
</script>
<script type="text/javascript"
        src="{{ asset('static/backend/js/admin/dashboard/customer.js?v='.time()) }}">
</script>
<script type="text/javascript"
        src="{{ asset('static/backend/js/admin/dashboard/expire-not-canceled.js?v='.time()) }}">
</script>
<script type="text/javascript"
        src="{{ asset('static/backend/js/admin/dashboard/expire-to-day.js?v='.time()) }}">
</script>
<script type="text/javascript"
        src="{{ asset('static/backend/js/admin/dashboard/expire-7-day.js?v='.time()) }}">
</script>
<script type="text/javascript"
        src="{{ asset('static/backend/js/admin/dashboard/expire-30-day.js?v='.time()) }}">
</script>
<script type="text/javascript"
        src="{{ asset('static/backend/js/admin/dashboard/receipt.js?v='.time()) }}">
</script>
<script type="text/javascript"
        src="{{ asset('static/backend/js/admin/dashboard/invoice.js?v='.time()) }}">
</script>
<script>
    var order_code = "@lang('admin::dashboard.order_code')";
    var customer = "@lang('admin::dashboard.customer')";
    var created_at = "@lang('admin::dashboard.customer')";
    var created_by = "@lang('admin::dashboard.created_by')";
    var amount = "@lang('admin::dashboard.amount')";
    var status = "@lang('admin::dashboard.status')";
    var customer_code = "@lang('admin::dashboard.customer_code')";
    var cmnd_mst = "@lang('admin::dashboard.cmnd_mst')";
    var type = "@lang('admin::dashboard.type')";
    var province = "@lang('admin::dashboard.province')";
    var customer_personal = "@lang('admin::dashboard.customer_personal')";
    var customer_enterprise = "@lang('admin::dashboard.customer_enterprise')";
    var status_new = "@lang('admin::dashboard.new')";
    var verified = "@lang('admin::dashboard.verified')";
    var service = "@lang('admin::dashboard.service')";
    var serviceCategory = "@lang('admin::dashboard.service_category')";
    var status_tt = "@lang('admin::dashboard.status_tt')";
    var actived_date = "@lang('admin::dashboard.actived_date')";
    var expired_date = "@lang('admin::dashboard.expired_date')";
    var action = "@lang('admin::dashboard.action')";
    var actived = "@lang('product::customer.service.actived')";
    var not_actived = "@lang('product::customer.service.not_actived')";
    var cancel = "@lang('product::customer.service.cancel')";
    var spending = "@lang('product::customer.service.spending')";
    var real = "@lang('product::customer.service.real')";
    var trial = "@lang('product::customer.service.trial')";
    KTAppOrderDatatable.setHeading({
        'order_code': order_code,
        'customer': customer,
        'created_at': created_at,
        'created_by': created_by,
        'amount': amount,
        'status': status,
    });
    KTAppCustomerDatatable.setHeading({
        'customer_code': customer_code,
        'customer': customer,
        'cmnd_mst': cmnd_mst,
        'type': type,
        'province': province,
        'created_at': created_at,
        'customer_personal': customer_personal,
        'customer_enterprise': customer_enterprise,
        'status_new': status_new,
        'verified': verified,
    });
    KTAppExpireNotCanceledDatatable.setHeading({
        'customer': customer,
        'service': service,
        'serviceCategory': serviceCategory,
        'status_tt': status_tt,
        'actived_date': actived_date,
        'expired_date': expired_date,
        'action': action,
        'actived': actived,
        'not_actived': not_actived,
        'cancel': cancel,
        'spending': spending,
        'real': real,
        'trial': trial,
    });
    KTAppExpireToDayDatatable.setHeading({
        'customer': customer,
        'service': service,
        'serviceCategory': serviceCategory,
        'status_tt': status_tt,
        'actived_date': actived_date,
        'expired_date': expired_date,
        'action': action,
        'actived': actived,
        'not_actived': not_actived,
        'cancel': cancel,
        'spending': spending,
        'real': real,
        'trial': trial,
    });
    KTAppExpireSevenDayDatatable.setHeading({
        'customer': customer,
        'service': service,
        'serviceCategory': serviceCategory,
        'status_tt': status_tt,
        'actived_date': actived_date,
        'expired_date': expired_date,
        'action': action,
        'actived': actived,
        'not_actived': not_actived,
        'cancel': cancel,
        'spending': spending,
        'real': real,
        'trial': trial,
    });
    KTAppExpire30DayDatatable.setHeading({
        'customer': customer,
        'service': service,
        'serviceCategory': serviceCategory,
        'status_tt': status_tt,
        'actived_date': actived_date,
        'expired_date': expired_date,
        'action': action,
        'actived': actived,
        'not_actived': not_actived,
        'cancel': cancel,
        'spending': spending,
        'real': real,
        'trial': trial,
    });
    $('.m_selectpicker').selectpicker();
</script>