/* 
 *Számot szöveges változóvá konvertáló js 
 */


function numberToSpell(int,b) {
if (b == null) {
   b = 1
   }
var s = '';


if (int > 999) {
   if (int > 2000) {
      s += numberToSpell(Math.floor(int / 1000),2)
      s += 'ezer-';
      } else {
      if (int == 2000) {
         s += 'kétezer';
         } else {
         s += 'ezer';
         }
      }
   }
if (int > 99) {
   var szazas = Math.floor(int % 1000 / 100);
   switch (szazas)
     {
     case 9: s += 'kilenc';
             break
     case 8: s += 'nyolc';
             break
     case 7: s += 'hét';
             break
     case 6: s += 'hat';
             break
     case 5: s += 'öt';
             break
     case 4: s += 'négy';
             break
     case 3: s += 'három';
             break
     case 2: s += 'két';
             break
     }
   if (szazas > 0) {
      s += 'száz';
      }
   }
var egyes = int % 10
if (int % 100 > 9) {
   var tizes = Math.floor(int % 100 / 10);
   switch(tizes) {
     case 1: if (egyes > 0) {
                s += 'tizen';
                } else {
                s += 'tíz';
                }
             break
     case 2: if (egyes > 0) {
                s += 'huszon';
                } else {
                s += 'húsz';
                }
             break
     case 3: s += 'harminc';
             break
     case 4: s += 'negyven';
             break
     case 5: s += 'ötven';
             break
     case 6: s += 'hatvan';
             break
     case 7: s += 'hetven';
             break
     case 8: s += 'nyolcvan';
             break
     case 9: s += 'kilencven';
             break
     }
   }
if (egyes > 0) {
   switch(egyes) {
     case 1: s += 'egy';
             break
     case 2: if (b == 1) {
                s += 'kettő'
                } else {
                s += 'két'
                }
             break
     case 3: s += 'három'
             break
     case 4: s += 'négy'
             break
     case 5: s += 'öt'
             break
     case 6: s += 'hat'
             break
     case 7: s += 'hét'
             break
     case 8: s += 'nyolc'
             break
     case 9: s += 'kilenc'
             break
     }
  }
   
return s
}


function spellToNumber(s) {
var s2 = s
var i = 0
var stemp = s2
while (s2.length > 0) {
  if (s2.substring(s2.length - 4,s2.length) == 'ezer') {
     if (s2.substring(0,s2.length - 4) != '') {
        i += 1000 * spellToNumber(s2.substring(0,s2.length - 4))
        } else {
        i += 1000
        }
     s2 = ''
     }
  if (s2.substring(s2.length - 6,s2.length) == 'ezer- ') {
     i += 1000 * spellToNumber(s2.substring(0,s2.length - 6))
     s2 = ''
     }
  if (s2.substring(s2.length - 4, s2.length) == 'száz') {
     var p = 1
     if (s2.substring(0,s2.length - 4) == "") {
        i += 100
        s2 = ''
        p = 0
        }
     if (s2.substring(s2.length - 7,s2.length - 4) == 'egy') {
        i += 100
        s2 = s2.substring(0,s2.length - 7)
        p = 0
        }
     if (s2.substring(s2.length - 7,s2.length - 4) == 'két') {
        i += 200
        s2 = s2.substring(0,s2.length - 7)
        p = 0
        }
     if (s2.substring(s2.length - 9,s2.length - 4) == 'kettő') {
        i += 200
        s2 = s2.substring(0,s2.length - 9)
        p = 0
        }
     if (s2.substring(s2.length - 9,s2.length - 4) == 'három') {
        i += 300
        s2 = s2.substring(0,s2.length - 9)
        p = 0
        }
     if (s2.substring(s2.length - 8,s2.length - 4) == 'négy') {
        i += 400
        s2 = s2.substring(0,s2.length - 8)
        p = 0
        }
     if (s2.substring(s2.length - 6,s2.length - 4) == 'öt') {
        i += 500
        s2 = s2.substring(0,s2.length - 6)
        p = 0
        }
     if (s2.substring(s2.length - 7,s2.length - 4) == 'hat') {
        i += 600
        s2 = s2.substring(0,s2.length - 7)
        p = 0
        }
     if (s2.substring(s2.length - 7,s2.length - 4) == 'hét') {
        i += 700
        s2 = s2.substring(0,s2.length - 7)
        p = 0
        }
     if (s2.substring(s2.length - 9,s2.length - 4) == 'nyolc') {
        i += 800
        s2 = s2.substring(0,s2.length - 9)
        p = 0
        }
     if (s2.substring(s2.length - 10,s2.length - 4) == 'kilenc') {
        i += 900
        s2 = s2.substring(0,s2.length - 10)
        p = 0
        }
     if (p == 1) {
        i += 100
        s2 = s2.substring(0,s2.length - 4)
        }
    }
  if (s2.substring(s2.length - 3, s2.length) == 'tíz') {
     i += 10
     s2 = s2.substring(0,s2.length - 3)
     }
  if (s2.substring(s2.length - 5, s2.length) == 'tizen') {
     i += 10
     s2 = s2.substring(0,s2.length - 5)
     }
  if (s2.substring(s2.length - 4, s2.length) == 'húsz') {
     i += 20
     s2 = s2.substring(0,s2.length - 4)
     }
  if (s2.substring(s2.length - 6, s2.length) == 'huszon') {
     i += 20
     s2 = s2.substring(0,s2.length - 6)
     }
  if (s2.substring(s2.length - 7, s2.length) == 'harminc') {
     i += 30
     s2 = s2.substring(0,s2.length - 7)
     }
  if (s2.substring(s2.length - 7, s2.length) == 'negyven') {
     i += 40
     s2 = s2.substring(0,s2.length - 7)
     }
  if (s2.substring(s2.length - 5, s2.length) == 'ötven') {
     i += 50
     s2 = s2.substring(0,s2.length - 5)
     }
  if (s2.substring(s2.length - 6, s2.length) == 'hatvan') {
     i += 60
     s2 = s2.substring(0,s2.length - 6)
     }
  if (s2.substring(s2.length - 6, s2.length) == 'hetven') {
     i += 70
     s2 = s2.substring(0,s2.length - 6)
     }
  if (s2.substring(s2.length - 8, s2.length) == 'nyolcvan') {
     i += 80
     s2 = s2.substring(0,s2.length - 8)
     }
  if (s2.substring(s2.length - 9, s2.length) == 'kilencven') {
     i += 90
     s2 = s2.substring(0,s2.length - 9)
     }
  if (s2.substring(s2.length - 3,s2.length) == 'egy') {
     i += 1
     s2 = s2.substring(0,s2.length - 3)
     }
  if (s2.substring(s2.length - 3,s2.length) == 'két') {
     i += 2
     s2 = s2.substring(0,s2.length - 3)
     }
  if (s2.substring(s2.length - 5,s2.length) == 'kettő') {
     i += 2
     s2 = s2.substring(0,s2.length - 5)
     }
  if (s2.substring(s2.length - 5,s2.length) == 'három') {
     i += 3
     s2 = s2.substring(0,s2.length - 5)
     }
  if (s2.substring(s2.length - 4,s2.length) == 'négy') {
     i += 4
     s2 = s2.substring(0,s2.length - 4)
     }
  if (s2.substring(s2.length - 2,s2.length) == 'öt') {
     i += 5
     s2 = s2.substring(0,s2.length - 2)
     }
  if (s2.substring(s2.length - 3,s2.length) == 'hat') {
     i += 6
     s2 = s2.substring(0,s2.length - 3)
     }
  if (s2.substring(s2.length - 3,s2.length) == 'hét') {
     i += 7
     s2 = s2.substring(0,s2.length - 3)
     }
  if (s2.substring(s2.length - 5,s2.length) == 'nyolc') {
     i += 8
     s2 = s2.substring(0,s2.length - 5)
     }
  if (s2.substring(s2.length - 6,s2.length) == 'kilenc') {
     i += 9
     s2 = s2.substring(0,s2.length - 6)
     }
  if (s2 == stemp) {
     alert('Hiba (valószínűleg rossz paraméter)')
     return 0
     }
  stemp = s2
  }
return i
}
