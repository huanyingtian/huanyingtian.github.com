
 var json = {show:function(foo){
            alert(foo.showMsg.showAge(arguments[1].age).msg1[0]);
            var aaa = foo.showMsg.showAge(arguments[1].age);
            aaa.msg2.push('css');
            alert(aaa.msg2[1]);
            foo.showMsg.showName(arguments[1].name);
            arguments[1].num1=30;
            alert(arguments[1].num1+arguments[1].num2);
            arguments[1]={name:'str2'};
            foo.showMsg.showName(arguments[1].name);
            foo.showMsg.showName(arguments[1].age);
        },
        showMsg:{
            showAge:function(age){
                alert(age);
                return {msg1:['你好','程序猿'],msg2:['js']}
            },
            showName:function(name){
                alert(name);

            }
        }
    };
    var person = {name:'str',age:34,num1:20,num2:40};
        json.show(json,person);