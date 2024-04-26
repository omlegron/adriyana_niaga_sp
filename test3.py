
print(len("000000000000000000001"))

def inputData(car):
    iAlias = -1;
    for i in range(1, 11):
        
        iAlias += 1
        for j in range(1, 21):
            if i == 1:
                print(car, end="")
            else:
                # print(i)
                res = iAlias * 2;
                res2 = res / 2;
                total = 10 - res2;
                total2 = 10 + res2 + 1;
                # print(total, end="")
                if j <= 10:
                    if j <= total:
                        print(car, end="")
                    elif j >= total:
                        print(" ", end = "")
                
                elif j >= 10:
                    if j >= total2:
                        print(car, end="")
                    elif j <= total2:
                        print(" ", end = "")
        print()
    
    for i in range(1, 10):
        iAlias = 0
        for j in range(1, 21):
            if i <= 9:
                kl = i
                kl += 1
                resLas = 10 + kl + 1
                if j <= 10:
                    if j <= kl:
                        print(car, end="")
                    else:
                        iAlias += 1
                        print(" ", end="")
        
                else:
                    res = iAlias + 11
                    if j >= res:
                        print(car, end="")
                    else:
                        print(" ", end="")
                    
            else:
                print(car, end="")
        print()
    print()
       

inputData(0)

                 
    # for($i = 1; $i <= 9; $i++){
    #     echo '<br>';
    #     $iAlias = 0;
    #     for($j = 1; $j <= 20; $j++){
    #         $no = $j;

    #         if($i <= 8){
    #             $kl = $i;
    #             $kl++;
    #             $resLas = 10 + $kl+1;
    #             if($j <= 10){
    #                 if($j <= $kl){
    #                     echo $car;
    #                 }else{
    #                     $iAlias += 1;
    #                     echo '&nbsp;';
    #                 }
    #             }else{
    #                 $res = $iAlias + 11;
    #                 if($j >= $res){
    #                     echo $car;
    #                 }else{
    #                     echo '&nbsp;&nbsp;&nbsp;';
    #                 }
    #             }
    #         }else{
    #             echo $car;
    #         }
    #     }
    # }
        