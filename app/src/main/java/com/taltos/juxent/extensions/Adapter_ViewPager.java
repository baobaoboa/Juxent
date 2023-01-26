package com.taltos.juxent.extensions;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.viewpager2.adapter.FragmentStateAdapter;

public class Adapter_ViewPager extends FragmentStateAdapter {
  private String page;

  public Adapter_ViewPager(@NonNull FragmentActivity fragmentActivity, String page) {
    super(fragmentActivity);
    this.page = page;
  }

  @NonNull
  @Override
  public Fragment createFragment(int position) {
    Fragment fragment = null;

    if (page.equalsIgnoreCase("Downloads")) {
      switch (position) {
//        case 0:
//          fragment = new Download_Sale();
//          break;
//        case 1:
//          fragment = new Download_Warranty();
//          break;
//        case 2:
//          fragment = new Download_Issue();
//          break;
//        default:
//          fragment = new Download_Sale();
//          break;
      }
    }

    return fragment;
  }

  @Override
  public int getItemCount() {
    int size = 0;

    switch (page) {
      case "Downloads":
        size = 3;
        break;
    }

    return size;
  }
}
