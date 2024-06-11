@if($orderStatus == 'pending')
    <span class="badge bg-warning text-warning-fg bg-secondary">Pending</span>
@elseif($orderStatus == 'Approved')
    <span class="badge bg-warning text-warning-fg" >Approved</span>
@elseif($orderStatus == 'Not_approved')
    <span class="badge bg-warning text-warning-fg" >Not approved</span>
@elseif($orderStatus == 'Delivering')
    <span class="badge bg-info text-info-fg" >Delivering</span>
@elseif($orderStatus == 'Delivered')
    <span class="badge bg-success text-success-fg" >Delivered</span>
@elseif($orderStatus == 'Canceled')
    <span class="badge bg-danger text-danger-fg">Canceled</span>
@endif
