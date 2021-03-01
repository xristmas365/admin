import '../scss/main.scss';
import {createBackdrop, removeBackdrop} from './global';

const $window = $(window);

const $menu = $('.menu-wrap');
const $navIcon = $('.nav-icon');
$navIcon.click(function () {
  const th = $(this);
  th.toggleClass('open');
  $menu.toggleClass('open');
  if (!$('div').is('.backdrop')) {
    const backdrop = createBackdrop();
    $(backdrop).click(function () {
      console.log('menu');
      $menu.removeClass('open');
      th.removeClass('open');
      removeBackdrop();
    });
  } else {
    removeBackdrop();
  }
});
const $showCart = $('.js-show-cart');
$showCart.click(function (e) {
  e.preventDefault();
  if ($menu.hasClass('open')) {
    $menu.removeClass('open');
    $navIcon.removeClass('open');
    removeBackdrop();
  }
  const backdrop = createBackdrop();
  backdrop.style['z-index'] = 102;
  const $cart = $('.cart');
  $cart.addClass('open');
  $(backdrop).click(function () {
    console.log('cart');
    $cart.removeClass('open');
    removeBackdrop();
  });
});

$window.scroll(function (e) {
  const $navContainer = $('.navigation');
  if ($(this).scrollTop()) {
    $navContainer.addClass('scrolled');
  } else {
    $navContainer.removeClass('scrolled');
  }
});
