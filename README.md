# sashimi: Automatic high-throughput pipeline for organismal image segmentation using deep learning
## web-interface

*To view the __sashimi__ Python pipeline, please visit: [https://github.com/ShawnTylerSchwartz/sashimi](https://github.com/ShawnTylerSchwartz/sashimi).*

*To view the __fish segmentation analyses_ files, please visit: [https://github.com/ShawnTylerSchwartz/fish-segmentation-analyses](https://github.com/ShawnTylerSchwartz/fish-segmentation-analyses).*

### Requirements
A local or online server with a LAMP (Linux, Apache, MySQL, PHP) stack, with read-write privileges. For a **demo**, please see [sashimi.shawntylerschwartz.com](https://sashimi.shawntylerschwartz.com). For **running locally**, see programs such as [MAMP](https://www.mamp.info/en/windows/).

To server images to users (or to yourself), please place as many directories within the `input/` directory, where the names of each subdirectory corresponds to the taxonomic group or some other grouping label for the images contained within that subdirectory. For example, `input/butterflyfishes/...`. 

To download segmented images and training data, please visit the `download.php` page to view data organized by subdirectory.

Images are randomly served to users (useful for crowdsourcing purposes). In order to manually view which images have been and not yet been completed, as well as to manually visit and complete/redo any previously segmented images, visit the `/admin/` directory and click on each subdirectory listing to view the progress of that directory. All output images are accessible via the `download.php` page or manually through the `/output/` directory on your server.