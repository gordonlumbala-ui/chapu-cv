import 'package:url_launcher/url_launcher.dart';

import '../core/app_constants.dart';

class ContactActions {
  static Future<bool> callSupport() {
    return launchUrl(Uri.parse(AppConstants.phoneTel));
  }

  static Future<bool> emailSupport() {
    return launchUrl(
      Uri.parse(
        '${AppConstants.emailMailto}?subject=${Uri.encodeComponent('Chapu CV Support')}',
      ),
    );
  }
}
