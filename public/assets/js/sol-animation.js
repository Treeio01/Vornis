class SolDepositAnimator {
  constructor() {
    this.depositData = [
      { amount: "24.32", address: "8uYK3Zf3Wg..." },
      { amount: "45.67", address: "9vLT4Rf2Hx..." },
      { amount: "18.94", address: "7qWE5Pd9Kz..." },
      { amount: "67.23", address: "5rMN8Vc4Ly..." },
      { amount: "33.88", address: "3pGH7Qe1Nw..." },
      { amount: "52.15", address: "6tRT9Xm5Jp..." },
      { amount: "29.76", address: "4sKL2Bw8Fv..." },
      { amount: "41.39", address: "2nHJ6Dy7Qr..." },
      { amount: "58.82", address: "1mFG5Ez3Xt..." },
      { amount: "73.14", address: "9cWR4Av6Yu..." },
      { amount: "16.55", address: "8bPQ3Hu9Zs..." },
      { amount: "62.41", address: "7aLK8Jv2Mp..." },
      { amount: "35.77", address: "6zNG4Tw5Xq..." },
      { amount: "48.93", address: "5yMH7Rs1Wo..." },
      { amount: "22.68", address: "4xJG6Qp8Vn..." }
    ];

    this.solContainer = null;
  }

  init() {
    console.log('Инициализация SOL депозитов анимации...');
    
    // Находим контейнер
    this.solContainer = $('#solList');
    
    console.log('SOL контейнер найден:', this.solContainer.length > 0);
    
    if (this.solContainer.length > 0) {
      this.startAnimation();
      console.log('SOL анимация запущена!');
    } else {
      console.error('SOL контейнер не найден!');
    }
  }

  startAnimation() {
    // Запускаем анимацию через 3 секунды после загрузки
    setTimeout(() => {
      this.scheduleNextDeposit();
    }, 3000);
  }

  scheduleNextDeposit() {
    // Рандомный интервал от 3 до 6 секунд
    const interval = Math.random() * 3000 + 1000;
    
    console.log(`Следующий SOL депозит через ${Math.round(interval/1000)} секунд`);
    
    setTimeout(() => {
      try {
        console.log('Добавляем новый SOL депозит');
        this.addNewDeposit();
      } catch (error) {
        console.error('Ошибка при добавлении SOL депозита:', error);
      }
      
      // Планируем следующий депозит
      this.scheduleNextDeposit();
    }, interval);
  }

  addNewDeposit() {
    const randomDeposit = this.depositData[Math.floor(Math.random() * this.depositData.length)];
    const newElement = this.createDepositElement(randomDeposit);
    this.animateNewElement(newElement);
  }

  createDepositElement(deposit) {
    return $(`
      <div class="flex p-3 bg-[#0C0C0C] w-full gap-2 items-center rounded-[6px] border border-white/6 sol-deposit-item" style="opacity: 0; transform: translateY(-50px) scale(0.95);">
        <img src="./assets/img/sol.svg" alt="">
        <span class="text-white leading-[130%] tracking-[-0.04em]">
          Deposited: ${deposit.amount} SOL
        </span>
      </div>
    `);
  }

  animateNewElement(newElement) {
    // Добавляем элемент в начало контейнера
    this.solContainer.prepend(newElement);
    
    console.log('SOL элемент добавлен, запускаем анимацию');
    
    // Добавляем эффект свечения
    newElement.addClass('sol-deposit-new');
    
    // Запускаем анимацию появления
    setTimeout(() => {
      newElement.css({
        'opacity': '1',
        'transform': 'translateY(0) scale(1)',
        'transition': 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)'
      });
    }, 100);

    // Анимируем сдвиг остальных элементов
    this.solContainer.children('.sol-deposit-item').not(newElement).each(function(index) {
      $(this).css({
        'transform': `translateY(${(index + 1) * 2}px)`,
        'transition': 'all 0.6s ease'
      });
      
      setTimeout(() => {
        $(this).css('transform', 'translateY(0)');
      }, 200);
    });

    // Убираем эффекты и лишние элементы
    setTimeout(() => {
      newElement.removeClass('sol-deposit-new');
      
      // Удаляем лишние элементы (оставляем только 3)
      const items = this.solContainer.children('.sol-deposit-item');
      if (items.length > 3) {
        items.slice(3).each(function() {
          $(this).fadeOut(600, function() {
            $(this).remove();
          });
        });
      }
    }, 2500);
  }
}

// Глобальная переменная
let solDepositAnimator;

// Инициализация после загрузки страницы
$(document).ready(function() {
  console.log('DOM готов, запускаем SOL анимацию через 2 секунды...');
  
  setTimeout(() => {
    solDepositAnimator = new SolDepositAnimator();
    solDepositAnimator.init();
  }, 2000);
});