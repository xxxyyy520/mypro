//申请等级表单校验
function checkreg() {
    var name = $.trim($("#name").val());
    var mobile = $("#mobile").val();
    var provid = $("#provid").val();
    var cityid = $("#cityid").val();
    var areaid = $("#areaid").val();
    var address = $.trim($("#address").val());
    if (name == "") {
        alert("请输入您的真实姓名");
        return false;
    }
    if (mobile == "") {
        alert("请输入您的有效联系方式");
        return false;
    } else {
        if (!isMobile(mobile)) {
            alert("您输入的联系方式格式有误");
            return false;
        }
    }
    if (provid == "" || cityid == "" || areaid == "") {
        alert("请选择所在区域");
        return false;
    }
    if (address == "") {
        alert("请填写详细地址");
        return false;
    }
    $("#subbutn").attr("onclick", "").html("保存中..");
    $("#subform").submit();
}
//申请提现类型切换
function chargetype() {
    var type = $("input[name='type']:checked").val();
    if (type == 1) {
        $(".box-private").hide();
        $(".box-company").show();
    } else {
        $(".box-company").hide();
        $(".box-private").show();
    }
}
//申请提现表单校验
function checkcharge() {
    var type = $("input[name='type']:checked").val();
    var username = $("#username").val();
    var identityid = $("#identityid").val();
    var cardid = $("#cardid").val();
    var cardname = $("#cardname").val();
    var certfilea = $("#certfilea").val();
    var certfileb = $("#certfileb").val();

    var username1 = $("#username1").val();
    var identityid1 = $("#identityid1").val();
    var cardid1 = $("#cardid1").val();
    var cardname1 = $("#cardname1").val();
    var certfile = $("#certfile").val();
    if (type == 0) {
        if (username == "") {
            alert("请输入真实姓名");
            return false;
        }
        if (identityid == "") {
            alert("请输入有效证件或营业执照号码");
            return false;
        }
        if (cardid == "") {
            alert("请输入银行账号或企业账号");
            return false;
        }
        if (cardname == "") {
            alert("请填写开户行名称");
            return false;
        }
        if (certfilea == "" || certfileb == "") {
            alert("请上传身份证照");
            return false;
        }
    }else{
        if (username1 == "") {
            alert("请输入企业名称");
            return false;
        }
        if (identityid1 == "") {
            alert("请输入有效证件或营业执照号码");
            return false;
        }
        if (cardid1 == "") {
            alert("请输入银行账号或企业账号");
            return false;
        }
        if (cardname1 == "") {
            alert("请填写开户行名称");
            return false;
        }
        if (certfile == "") {
            alert("请上传营业执照");
            return false;
        }
    }
    $("#subbutn").attr("onclick", "").html("保存中..");
    $("#subform").submit();
}
//下单表单校验
function checkorders() {
    var name = $("#name").val();
    var mobile = $("#mobile").val();
    var provid = $("#provid").val();
    var cityid = $("#cityid").val();
    var areaid = $("#areaid").val();
    var address = $("#address").val();
    // var nums = $("#nums").val();
    if (name == "") {
        alert("请输入收货人姓名");
        return false;
    }
    if (mobile == "") {
        alert("请输入收货人的有效手机号");
        return false;
    } else {
        if (!isMobile(mobile)) {
            alert("您输入的联系方式格式有误");
            return false;
        }
    }
    if (provid == "" || cityid == "" || areaid == "") {
        alert("请选择收货区域省市区");
        return false;
    }
    if (address == "") {
        alert("请输入详细的收货地址");
        return false;
    }
    // if (nums == "") {
    //     alert("请输入合理的购买数量");
    //     return false;
    // } else {
    //     if (!isNumber(nums)) {
    //         alert("请输入正确的购买数量");
    //         return false;
    //     }
    // }
    $("#subbutn").attr("onclick", "").html("下单中..");
    $("#subform").submit();
}
//修改数量
function changenums(e) {
    var nums = parseInt($("#nums").val());
    if (e == 1) {
        if (nums > 5) {
            nums--;
            $("#nums").attr("value", nums);
        } else {
            return false;
        }
    } else {
        nums++;
        $("#nums").attr("value", nums);
    }
    changeprice();
}

// 监控输入数量
$("#nums").live("input propertychange", function() {
    var nums = parseInt($("#nums").val());
    if (!isNumber(nums)) {
        alert("请输入合理的数量");
        return false;
    } else {
        if (nums < 1) {
            return false;
        }
    }
    changeprice();
});

//修改价格
function changeprice() {
    var nums = $("#nums").val();
    // alert(nums)
    var price = $("#priceone").val();
    // alert(price)
    var allprice = parseInt(nums) * price;
    $("#allprice").html(allprice);
}
//提现申请
function checkcharged() {
    var minprice = $("#minprice").val();
    var price = $("#price").val();
    if (price == "") {
        alert("请输入提现金额");
        return false;
    } else {
        if (!isMoney(price)) {
            alert("输入的提现金额格式有误");
            return false;
        }
    }
    if (price > minprice) {
        alert("可用余额不足");
        return false;
    }
    if (price < 1) {
        alert("金额不得少于1元");
        return false;
    }
    $("#subbutn").attr("onclick", "").html("申请中..");
    $("#subform").submit();
}
//在线登记
function register(status) {
    if (status == 0) {
        window.location.href = S_ROOT + 'user/regform';
    } else {
        alert('您已申请过！')
    }
}
//提现申请
function charge(sign) {
    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT + "user/charge",
        data: "sign=" + sign,
        success: function(rows) {
            if (rows == 1) {
                alert('正在实名审核中！');
            } else {
                window.location.href = S_ROOT + 'user/charge';
            }
        }
    });
}

//个人中心
function identity() {
    $.ajax({
        type: "POST",
        async: false,
        url: S_ROOT + "user/ucenter",
        data: 'data=data',
        success: function(rows) {
            // alert(rows);
            if (rows == 1) {
                alert('正在实名审核中！');
            } else {
                window.location.href = S_ROOT + 'user/chargerealname';
            }
        }
    });
}